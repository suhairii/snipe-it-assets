@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.consumables') }} - Laporan Stok Custom
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        
        {{-- Tabel Snipe-IT Custom --}}
        <table
            id="consumablesTable"
            class="table table-striped snipe-table"
            
            {{-- Konfigurasi Sumber Data --}}
            data-url="{{ route('api.custom.stock-report') }}"
            data-method="get"
            
            {{-- Konfigurasi Tampilan & Fitur --}}
            data-cookie="true"
            data-cookie-id-table="consumablesTableCustom"
            data-side-pagination="client"  {{-- PENTING: 'client' agar search/sort berfungsi otomatis --}}
            data-pagination="true"
            data-show-footer="true"
            data-search="true"
            data-show-refresh="true"
            data-show-columns="true"
            data-show-export="true"
            data-sort-order="asc"
            data-sort-name="consumable_name"
            data-toolbar="#toolbar"
            
            data-export-options='{
                "fileName": "laporan-stok-{{ date('Y-m-d') }}"
            }'>

            <thead>
                <tr>
                    {{-- Mapping Kolom Database View ke Kolom Tabel HTML --}}
                    
                    {{-- MODIFIKASI: Menambahkan data-formatter="nameFormatter" --}}
                    <th data-field="consumable_name" data-sortable="true" data-searchable="true" data-formatter="nameFormatter">
                        Nama Barang
                    </th>
                    
                    <th data-field="assigned_to_name" data-sortable="true" data-searchable="true">
                        Penerima
                    </th>
                    
                    <th data-field="quantity_assigned" data-sortable="true">
                        Jumlah Keluar
                    </th>
                    
                    <th data-field="assigned_date" data-sortable="true" data-formatter="dateFormatter">
                        Tanggal
                    </th>
                    
                    <th data-field="total_stock" data-sortable="true">
                        Sisa Stok
                    </th>
                </tr>
            </thead>
        </table>

      </div></div></div> </div> @stop

@section('moar_scripts')
<script>
    // MODIFIKASI: Fungsi untuk membuat link pada Nama Barang
    function nameFormatter(value, row) {
        if (value) {
            // row.consumable_id didapat dari View Database yang sudah diupdate
            // Link mengarah ke detail consumable
            return '<a href="{{ url('/') }}/consumables/' + row.consumable_id + '">' + value + '</a>';
        }
        return value;
    }

    // Fungsi format tanggal
    function dateFormatter(value, row) {
        if (value) {
            return new Date(value).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
            });
        }
        return value;
    }
</script>

{{-- Memuat Library Bootstrap Table --}}
@include ('partials.bootstrap-table')
@stop