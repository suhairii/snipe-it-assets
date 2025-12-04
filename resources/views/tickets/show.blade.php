@extends('layouts/default')

@section('title0')
    Detail Tiket #{{ $ticket->id }}
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Info Aset</h3>
            </div>
            <div class="box-body">
                <strong>Aset:</strong> <br>
                @if($ticket->asset)
                    <a href="{{ route('hardware.show', $ticket->asset_id) }}">
                        {{ $ticket->asset->asset_tag }} - {{ $ticket->asset->name }}
                    </a>
                @else
                    <span class="text-danger">Aset Hilang</span>
                @endif
                <hr>
                <strong>Pelapor:</strong> <br> {{ $ticket->user->first_name }} {{ $ticket->user->last_name }}
                <hr>
                <strong>Masalah Awal:</strong> <br>
                <p class="text-muted">{{ $ticket->description }}</p>
                <hr>
                <strong>Status:</strong> 
                <span class="label label-{{ $ticket->statusLabel() }}">{{ ucfirst($ticket->status) }}</span>
                <br><br>
                <a href="{{ url()->previous() }}" class="btn btn-default btn-block">Kembali</a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-success direct-chat direct-chat-success">
            <div class="box-header with-border">
                <h3 class="box-title">Percakapan / Diskusi</h3>
            </div>
            
            <div class="box-body">
                <div class="direct-chat-messages" style="height: 400px;">
                    
                    <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left">{{ $ticket->user->first_name }}</span>
                            <span class="direct-chat-timestamp pull-right">{{ $ticket->created_at->format('d M H:i') }}</span>
                        </div>
                        @if($ticket->user->avatar)
                            <img class="direct-chat-img" src="{{ url('/') }}/uploads/avatars/{{ $ticket->user->avatar }}" alt="User Image">
                        @else
                            <img class="direct-chat-img" src="{{ url('/') }}/img/default-sm.png" alt="User Image">
                        @endif
                        <div class="direct-chat-text">
                            {{ $ticket->description }}
                        </div>
                    </div>

                    @foreach($ticket->comments as $comment)
                        @php
                            $isMe = ($comment->user_id == Auth::id());
                        @endphp
                        <div class="direct-chat-msg {{ $isMe ? 'right' : '' }}">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-{{ $isMe ? 'right' : 'left' }}">
                                    {{ $comment->user->first_name }} 
                                    @if($comment->user->isSuperUser() || $comment->user->hasAccess('admin')) 
                                        <span class="label label-warning" style="font-size: 9px;">Admin</span>
                                    @endif
                                </span>
                                <span class="direct-chat-timestamp pull-{{ $isMe ? 'left' : 'right' }}">
                                    {{ $comment->created_at->format('d M H:i') }}
                                </span>
                            </div>
                            
                            @if($comment->user->avatar)
                                <img class="direct-chat-img" src="{{ url('/') }}/uploads/avatars/{{ $comment->user->avatar }}" alt="User Image">
                            @else
                                <img class="direct-chat-img" src="{{ url('/') }}/img/default-sm.png" alt="User Image">
                            @endif

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
                        <input type="text" name="message" placeholder="Tulis pesan..." class="form-control" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success btn-flat">Kirim</button>
                        </span>
                    </div>
                </form>
                @else
                    <div class="alert alert-warning text-center" style="margin-bottom: 0;">
                        Tiket ini sudah ditutup. Tidak bisa membalas.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop