<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar tiket milik user yang sedang login.
     */
    public function myTickets()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tickets = Ticket::where('user_id', Auth::id())
                        // PERBAIKAN UTAMA DI SINI:
                        // Kita gunakan closure function untuk memaksa sistem menampilkan aset
                        // meskipun user biasa tidak punya izin 'View All Assets'.
                        ->with(['asset' => function ($query) {
                            $query->withoutGlobalScopes(); 
                        }])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('tickets.index', compact('tickets'));
    }
    /**
     * Menampilkan formulir pembuatan tiket baru.
     */
    public function create()
    {
        $user = Auth::user();

        // LOGIKA PERBAIKAN ASET USER BIASA:
        // 1. Coba ambil dari relasi user->assets (standar Snipe-IT)
        $myAssets = $user->assets;

        // 2. Jika kosong (karena limitasi permission), ambil paksa menggunakan withoutGlobalScopes
        if ($myAssets->isEmpty()) {
            $myAssets = Asset::withoutGlobalScopes()
                             ->where('assigned_to', $user->id)
                             ->where('assigned_type', 'App\Models\User')
                             ->whereNull('deleted_at') // Hanya yang belum dihapus
                             ->where('status_id', '!=', 0) // Hanya status valid
                             ->get();
        }

        return view('tickets.create', compact('myAssets'));
    }

    /**
     * Menyimpan data tiket ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:191',
            'asset_id' => 'required', // Kita validasi manual di bawah untuk user biasa
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Simpan ke database
        $ticket = new Ticket();
        $ticket->user_id = Auth::id();
        $ticket->asset_id = $request->input('asset_id');
        $ticket->subject = $request->input('subject');
        $ticket->description = $request->input('description');
        $ticket->status = 'open';
        $ticket->created_by = Auth::id();
        $ticket->save();

        return redirect()->route('tickets.my')->with('success', 'Tiket perbaikan berhasil dikirim.');
    }

    /**
     * Halaman Admin untuk mengelola semua tiket.
     */
    public function manage()
    {
        // Cek apakah user adalah Admin/Superadmin
        if (!Auth::user()->isSuperUser() && !Auth::user()->hasAccess('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $tickets = Ticket::with(['user', 'asset'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('tickets.manage', compact('tickets'));
    }

    /**
     * Proses update status (Approve/Reject) oleh Admin.
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::user()->isSuperUser() && !Auth::user()->hasAccess('admin')) {
            abort(403);
        }

        $ticket = Ticket::findOrFail($id);
        
        if ($request->has('status')) {
            $ticket->status = $request->input('status');
        }
        
        if ($request->has('admin_comment')) {
            $ticket->admin_comment = $request->input('admin_comment');
        }

        $ticket->save();

        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui.');
    }
   /**
     * Tampilkan Detail Tiket & Chat Room
     */
    public function show($id)
    {
        // PERBAIKAN: Tambahkan 'withoutGlobalScopes' pada relasi asset & user
        // agar data tetap muncul meskipun user biasa tidak punya akses lihat semua aset
        $ticket = Ticket::with([
            'comments.user', 
            'user' => function($q){
                $q->withoutGlobalScopes();
            },
            'asset' => function($q){
                $q->withoutGlobalScopes();
            }
        ])->findOrFail($id);

        // Keamanan: Pastikan yang buka adalah Pemilik Tiket ATAU Admin
        if (Auth::id() != $ticket->user_id && !Auth::user()->isSuperUser() && !Auth::user()->hasAccess('admin')) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Simpan Chat / Komentar Baru
     */
    public function storeComment(Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($id);

        // Simpan Komentar
        $comment = new \App\Models\TicketComment();
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        $comment->message = $request->input('message');
        $comment->save();

        // (Opsional) Update Tiket jadi "Pending" jika Admin yang balas
        // Agar user tahu ada update
        if (Auth::user()->isSuperUser() || Auth::user()->hasAccess('admin')) {
             if($ticket->status == 'open') {
                 $ticket->status = 'pending';
                 $ticket->save();
             }
        }

        return redirect()->route('tickets.show', $id)->with('success', 'Pesan terkirim.');
    }
}