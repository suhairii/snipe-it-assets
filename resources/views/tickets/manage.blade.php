@extends('layouts/default')

@section('title0')
    Kelola Tiket Masuk
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Semua Pengajuan</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Pelapor</th>
                            <th>Aset</th>
                            <th>Masalah</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>
                                {{-- Optional user agar tidak error jika user resign --}}
                                {{ optional($ticket->user)->first_name ?? 'User' }} 
                                {{ optional($ticket->user)->last_name ?? '' }}
                                <br>
                                <small class="text-muted">
                                    {{ $ticket->created_at->format('d M Y H:i') }}
                                </small>
                            </td>
                            <td>
                                @if($ticket->asset)
                                    <a href="{{ route('hardware.show', $ticket->asset_id) }}" target="_blank">
                                        {{ $ticket->asset->asset_tag }}
                                    </a>
                                    <br>
                                    <small>{{ $ticket->asset->name }}</small>
                                @else
                                    <span class="text-danger" style="font-style:italic;">Aset Hilang</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $ticket->subject }}</strong>
                                <p class="text-muted" style="margin-top:5px; font-size:0.9em;">
                                    {{ str_limit($ticket->description, 50) }}
                                </p>
                            </td>

                            {{-- Kolom Durasi --}}
                            <td>
                                @if($ticket->status != 'closed')
                                    <span class="badge bg-orange">
                                        <i class="fa fa-spinner fa-spin"></i> {{ $ticket->duration }}
                                    </span>
                                @else
                                    <span class="badge bg-gray">
                                        Selesai: {{ $ticket->duration }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $statusClass = 'default';
                                    if($ticket->status == 'open') $statusClass = 'primary';
                                    if($ticket->status == 'approved') $statusClass = 'success';
                                    if($ticket->status == 'rejected') $statusClass = 'danger';
                                    if($ticket->status == 'pending') $statusClass = 'warning';
                                @endphp
                                <span class="label label-{{ $statusClass }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            
                            {{-- Kolom Aksi (Approval & Chat) --}}
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info btn-xs btn-block" style="margin-bottom: 5px;">
                                    <i class="fa fa-comments-o"></i> Buka Chat & Detail
                                </a>

                                @if($ticket->status == 'open' || $ticket->status == 'pending')
                                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{-- Input Hidden agar form valid --}}
                                        <input type="hidden" name="admin_comment" value="Status updated by admin">
                                        
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <button type="submit" name="status" value="approved" class="btn btn-success btn-xs" title="Setujui">
                                                    <i class="fa fa-check"></i> Appr
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="submit" name="status" value="rejected" class="btn btn-danger btn-xs" title="Tolak">
                                                    <i class="fa fa-times"></i> Rej
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="submit" name="status" value="pending" class="btn btn-warning btn-xs" title="Tunda">
                                                    <i class="fa fa-pause"></i> Pend
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    @if($ticket->status != 'closed')
                                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" style="margin-top:5px;">
                                        {{ csrf_field() }}
                                        <button type="submit" name="status" value="closed" class="btn btn-default btn-block btn-xs">
                                            <i class="fa fa-lock"></i> Tandai Selesai
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada tiket masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop