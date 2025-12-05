@extends('layouts/default')

@section('title0')
    Kelola Tiket Masuk
@stop

{{-- Tambahan CSS agar kolom aksi benar-benar hilang saat Print Browser (Ctrl+P) --}}
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
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Semua Pengajuan</h3>
            </div>
            <div class="box-body">
                
                {{-- Toolbar --}}
                <div id="toolbar">
                </div>

                {{-- Konfigurasi Tabel --}}
                <table
                    id="ticketsTable"
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
                    
                    {{-- KONFIGURASI EXPORT: Abaikan kolom dengan data-field="actions" --}}
                    data-export-options='{
                        "fileName": "laporan-tiket-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions"] 
                    }'>
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" style="width: 50px;">ID</th>
                            <th data-field="reporter" data-sortable="true">Pelapor</th>
                            <th data-field="asset" data-sortable="true">Aset</th>
                            <th data-field="issue" data-sortable="true">Masalah</th>
                            <th data-field="duration" data-sortable="true">Durasi</th>
                            <th data-field="status" data-sortable="true">Status</th>
                            
                            {{-- KONFIGURASI KOLOM AKSI --}}
                            <th data-field="actions" 
                                data-sortable="false" 
                                data-switchable="false" 
                                data-print-ignore="true" 
                                class="no-print" 
                                style="width: 250px;">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>
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

                            {{-- Kolom Durasi Realtime --}}
                            <td>
                                @if($ticket->status != 'closed')
                                    <span class="badge bg-orange">
                                        <i class="fa fa-spinner fa-spin"></i> 
                                        {{-- Class live-timer & data-created-at ditambahkan untuk JS --}}
                                        <span class="live-timer" data-created-at="{{ $ticket->created_at->format('Y-m-d H:i:s') }}">
                                            {{ $ticket->duration }}
                                        </span>
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
                            
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info btn-xs btn-block" style="margin-bottom: 5px;">
                                    <i class="fa fa-comments-o"></i> Buka Chat & Detail
                                </a>

                                @if($ticket->status == 'open' || $ticket->status == 'pending')
                                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="admin_comment" value="Status updated by admin">
                                        
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <button type="submit" name="status" value="approved" class="btn btn-success btn-xs" title="Setujui">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="submit" name="status" value="rejected" class="btn btn-danger btn-xs" title="Tolak">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="submit" name="status" value="pending" class="btn btn-warning btn-xs" title="Tunda">
                                                    <i class="fa fa-pause"></i>
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
                        {{-- Empty state handled by table --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

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