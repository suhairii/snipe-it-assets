@extends('layouts/default')

@section('title0')
    Detail Tiket #{{ $ticket->id }}
@stop

{{-- Tambahan CSS Khusus --}}
@push('css')
<style>
    /* 1. ICON AVATAR REPLACEMENT */
    .icon-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        font-size: 18px;
        color: #fff;
        display: inline-block;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    /* Warna Placeholder Icon (User Lain) */
    .direct-chat-msg .direct-chat-img.icon-placeholder {
        background-color: #6c757d; /* Abu-abu modern */
        color: #fff;
    }
    
    /* Warna Placeholder Icon (Saya) */
    .direct-chat-msg.right .direct-chat-img.icon-placeholder {
        background-color: #3b82f6; /* Biru utama */
        color: #fff;
    }

    /* Warna Placeholder Icon (Admin) */
    .is-admin-icon {
        background-color: #f59e0b !important; /* Kuning/Orange */
        color: #fff !important;
    }

    /* 2. CHAT BUBBLE STYLING (PERBAIKAN UTAMA) */
    .direct-chat-text {
        border-radius: 12px;
        border: none; /* Hapus border bawaan agar lebih clean */
        margin: 5px 0 0 50px; /* Default margin kiri untuk user lain */
        padding: 10px 15px;
        
        /* PENTING: Agar lebar menyesuaikan teks */
        display: inline-block; 
        max-width: 75%; /* Batas maksimal lebar bubble */
        word-wrap: break-word; /* Agar kata panjang turun ke bawah */
        float: left; /* Paksa ke kiri */
        position: relative;
    }

    /* Bubble User Lain (Kiri) */
    .direct-chat-msg .direct-chat-text {
        background: #f3f4f6; /* Abu-abu terang */
        color: #1f2937;
        border-top-left-radius: 0; /* Sudut lancip di dekat avatar */
    }

    /* Bubble Saya (Kanan) */
    .direct-chat-msg.right .direct-chat-text {
        background: #3b82f6; /* Biru */
        color: #fff;
        margin: 5px 50px 0 0; /* Margin kanan untuk memberi ruang avatar */
        float: right; /* Paksa ke kanan */
        border-top-left-radius: 12px;
        border-top-right-radius: 0; /* Sudut lancip di dekat avatar kanan */
        border-color: #3b82f6;
    }

    /* Menghilangkan panah segitiga kecil bawaan AdminLTE agar lebih modern */
    .direct-chat-text:before, .direct-chat-text:after {
        border-width: 0 !important;
        display: none !important;
    }

    /* Fix Layout Clearing - Agar chat tidak bertumpuk */
    .direct-chat-msg::after {
        content: "";
        display: table;
        clear: both;
    }
    .direct-chat-msg {
        margin-bottom: 15px; /* Jarak antar pesan vertikal */
    }

    /* 3. INFO TABLE STYLING */
    .ticket-info-table th { width: 35%; color: #6b7280; font-weight: 500; }
    .ticket-info-table td { font-weight: 600; color: #374151; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i> Informasi Tiket</h3>
            </div>
            <div class="box-body">
                
                {{-- Status Label Besar --}}
                <div class="text-center" style="margin-bottom: 20px;">
                    <span style="font-size: 14px; display:block; margin-bottom:5px; color:#777;">Status Saat Ini</span>
                    <span class="label label-{{ $ticket->statusLabel() }}" style="font-size: 16px; padding: 8px 15px;">
                        {{ strtoupper($ticket->status) }}
                    </span>
                </div>

                <table class="table table-striped ticket-info-table">
                    <tbody>
                        <tr>
                            <th><i class="fa fa-barcode"></i> Aset</th>
                            <td>
                                @if($ticket->asset)
                                    <a href="{{ route('hardware.show', $ticket->asset_id) }}" style="text-decoration: underline;">
                                        {{ $ticket->asset->asset_tag }}
                                    </a>
                                    <div style="font-size: 12px; color: #555; font-weight: normal;">
                                        {{ $ticket->asset->name }}
                                    </div>
                                @else
                                    <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Aset Hilang</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-user"></i> Pelapor</th>
                            <td>
                                {{ $ticket->user->first_name }} {{ $ticket->user->last_name }}
                                <div style="font-size: 11px; color: #999;">User</div>
                            </td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-calendar"></i> Tanggal</th>
                            <td>{{ $ticket->created_at->format('d M Y') }} <br> <small>{{ $ticket->created_at->format('H:i') }} WIB</small></td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                
                <strong><i class="fa fa-align-left"></i> Deskripsi Masalah:</strong>
                <div class="well well-sm" style="margin-top: 10px; background: #f9fafc; border: 1px solid #eee; border-radius: 8px;">
                    <p class="text-muted" style="margin: 0;">
                        {{ $ticket->description }}
                    </p>
                </div>

                <br>
                <a href="{{ url()->previous() }}" class="btn btn-default btn-block">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-success direct-chat direct-chat-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-comments"></i> Diskusi / Percakapan</h3>
                <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="Total Pesan" class="badge bg-green">{{ $ticket->comments->count() + 1 }}</span>
                </div>
            </div>
            
            <div class="box-body">
                <div class="direct-chat-messages" style="height: 450px; padding: 20px;">
                    
                    <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left">{{ $ticket->user->first_name }} (Pelapor)</span>
                            <span class="direct-chat-timestamp pull-right">{{ $ticket->created_at->format('d M H:i') }}</span>
                        </div>
                        
                        <div class="direct-chat-img icon-placeholder icon-avatar">
                            <i class="fa fa-user"></i>
                        </div>

                        <div class="direct-chat-text">
                            {{ $ticket->description }}
                        </div>
                    </div>

                    @foreach($ticket->comments as $comment)
                        @php
                            $isMe = ($comment->user_id == Auth::id());
                            $isAdmin = ($comment->user->isSuperUser() || $comment->user->hasAccess('admin'));
                        @endphp
                        
                        <div class="direct-chat-msg {{ $isMe ? 'right' : '' }}">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-{{ $isMe ? 'right' : 'left' }}">
                                    {{ $comment->user->first_name }} 
                                    @if($isAdmin) 
                                        <span class="label label-warning" style="font-size: 9px; position: relative; top: -2px;">Admin</span>
                                    @endif
                                </span>
                                <span class="direct-chat-timestamp pull-{{ $isMe ? 'left' : 'right' }}">
                                    {{ $comment->created_at->format('d M H:i') }}
                                </span>
                            </div>
                            
                            <div class="direct-chat-img icon-placeholder icon-avatar {{ $isAdmin && !$isMe ? 'is-admin-icon' : '' }}">
                                <i class="fa {{ $isAdmin ? 'fa-user-secret' : 'fa-user' }}"></i>
                            </div>

                            <div class="direct-chat-text">
                                {{ $comment->message }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="box-footer">
                @if($ticket->status != 'closed')
                <form action="{{ route('tickets.comment', $ticket->id) }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Ketik balasan disini..." class="form-control" required style="height: 40px; border-radius: 20px 0 0 20px;">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success btn-flat" style="height: 40px; padding: 0 20px; border-radius: 0 20px 20px 0;">
                                <i class="fa fa-paper-plane"></i> Kirim
                            </button>
                        </span>
                    </div>
                </form>
                @else
                    <div class="callout callout-warning text-center" style="margin-bottom: 0; padding: 10px; border-radius: 8px;">
                        <i class="fa fa-lock"></i> Tiket ini sudah ditutup (Closed). Tidak bisa membalas.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop