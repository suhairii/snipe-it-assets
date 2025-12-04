<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Asset;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'user_id',
        'asset_id',
        'subject',
        'description',
        'status',
        'admin_comment',
        'created_by',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function statusLabel()
    {
        switch ($this->status) {
            case 'open': return 'primary';
            case 'approved': return 'success';
            case 'rejected': return 'danger';
            case 'closed': return 'default';
            default: return 'warning';
        }
    }
    /**
     * Accessor untuk menghitung durasi tiket.
     * Pemanggilan di view: $ticket->duration
     */
    public function getDurationAttribute()
    {
        // Jika tiket sudah ditutup (Selesai/Closed)
        if ($this->status == 'closed') {
            // Hitung selisih antara waktu dibuat dan waktu terakhir diupdate (saat diclose)
            // Parameter 'true' berarti formatnya ringkas (contoh: "2 days" bukan "2 days ago")
            return $this->created_at->diffForHumans($this->updated_at, true);
        }

        // Jika tiket masih berjalan (Open, Pending, dll)
        // Hitung selisih antara waktu dibuat dan SEKARANG
        return $this->created_at->diffForHumans(null, true);
    }
}