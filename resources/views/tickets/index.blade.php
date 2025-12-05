@extends('layouts/default')

@section('title0')
    Riwayat Pengajuan Saya
@stop

{{-- Tambahan CSS agar kolom aksi benar-benar hilang saat Print Browser --}}
@push('css')
<style>
    @media print {
        .no-print, .actions-column {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Tiket Anda</h3>
            </div>
            <div class="box-body">
                
                {{-- 1. TOOLBAR: Tombol "Buat Baru" dipindah ke sini agar rapi --}}
                <div id="toolbar">
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Buat Baru
                    </a>
                </div>

                {{-- 2. KONFIGURASI BOOTSTRAP TABLE --}}
                <table
                    id="myTicketsTable"
                    class="table table-striped snipe-table"
                    data-toggle="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-show-refresh="true"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-print="true"
                    data-pagination="true"
                    data-side-pagination="client"
                    data-page-size="20"
                    data-export-options='{
                        "fileName": "riwayat-tiket-saya-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions"]
                    }'>
                    <thead>
                        <tr>
                            {{-- Tambahkan data-field dan data-sortable --}}
                            <th data-field="id" data-sortable="true" style="width: 50px;">ID</th>
                            <th data-field="created_at" data-sortable="true">Tanggal</th>
                            <th data-field="asset" data-sortable="true">Aset</th>
                            <th data-field="title" data-sortable="true">Judul</th>
                            <th data-field="status" data-sortable="true">Status</th>
                            <th data-field="duration" data-sortable="true">Durasi</th>
                            
                            {{-- Kolom Aksi: Diabaikan saat Print/Export --}}
                            <th data-field="actions" 
                                data-sortable="false" 
                                data-switchable="false" 
                                data-print-ignore="true" 
                                class="no-print" 
                                style="width: 150px;">
                                Aksi
                            </th>
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
                            
                            {{-- Kolom Durasi Realtime --}}
                            <td>
                                @if($ticket->status != 'closed')
                                    <small class="text-orange">
                                        <i class="fa fa-clock-o"></i> 
                                        {{-- Class live-timer & data-created-at ditambahkan untuk JS --}}
                                        <span class="live-timer" data-created-at="{{ $ticket->created_at->format('Y-m-d H:i:s') }}">
                                            {{ $ticket->duration }}
                                        </span>
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
                        {{-- Bootstrap table akan menangani empty state --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

{{-- 3. LOAD SCRIPT BOOTSTRAP TABLE & REALTIME CLOCK --}}
@section('moar_scripts')
    @include ('partials.bootstrap-table')

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        
        function updateDurations() {
            var timers = document.querySelectorAll('.live-timer');
            var now = new Date();

            timers.forEach(function(timer) {
                var createdStr = timer.getAttribute('data-created-at');
                // Ganti spasi dengan T agar format ISO (Safari support)
                var createdDate = new Date(createdStr.replace(' ', 'T'));
                var diff = now - createdDate;

                if (diff > 0) {
                    var seconds = Math.floor(diff / 1000);
                    var minutes = Math.floor(seconds / 60);
                    var hours = Math.floor(minutes / 60);
                    var days = Math.floor(hours / 24);

                    hours %= 24;
                    minutes %= 60;
                    seconds %= 60;

                    var result = "";
                    if (days > 0) result += days + " hari ";
                    if (hours > 0 || days > 0) result += hours + " jam ";
                    result += minutes + " mnt ";
                    result += seconds + " dtk";

                    timer.innerText = result;
                }
            });
        }

        // Update setiap 1 detik
        setInterval(updateDurations, 1000);
        // Jalankan langsung saat load
        updateDurations();
    });
    </script>
@stop