@extends('layouts/default')

@section('title0')
    Riwayat Pengajuan Saya
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Tiket Anda</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Buat Baru
                    </a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Tanggal</th>
                            <th>Aset</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Durasi</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>#{{ $ticket->id }}</td>
                            <td>
                                {{ $ticket->created_at ? $ticket->created_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td>
                                {{-- Menggunakan optional/check agar tidak error --}}
                                @if($ticket->asset)
                                    <a href="{{ route('hardware.show', $ticket->asset_id) }}">
                                        {{ $ticket->asset->asset_tag }}
                                    </a>
                                    <br>
                                    <small>{{ $ticket->asset->name }}</small>
                                @else
                                    <span class="text-danger" style="font-style:italic;">(Aset Tidak Ditemukan)</span>
                                @endif
                            </td>
                            <td>{{ $ticket->subject }}</td>
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
                            
                            {{-- Kolom Durasi --}}
                            <td>
                                @if($ticket->status != 'closed')
                                    <small class="text-orange">
                                        <i class="fa fa-clock-o"></i> {{ $ticket->duration }}
                                    </small>
                                @else
                                    <small class="text-muted">
                                        <i class="fa fa-check-circle"></i> {{ $ticket->duration }}
                                    </small>
                                @endif
                            </td>

                            {{-- Tombol Aksi --}}
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-info btn-block">
                                    <i class="fa fa-comments-o"></i> Chat / Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada riwayat pengajuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop