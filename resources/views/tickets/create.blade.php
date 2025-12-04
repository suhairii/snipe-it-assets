@extends('layouts/default')

@section('title0')
    Buat Pengajuan Perbaikan
@stop

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Formulir Kerusakan Aset</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" method="post" action="{{ route('tickets.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group {{ $errors->has('asset_id') ? 'has-error' : '' }}">
                        <label class="col-md-3 control-label">Pilih Aset Anda</label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="asset_id" style="width: 100%;">
                                <option value="">-- Pilih Aset --</option>
                                @foreach($myAssets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->asset_tag }} - {{ $asset->name }}</option>
                                @endforeach
                            </select>
                            @if($myAssets->isEmpty())
                                <p class="help-block text-red">Anda tidak memiliki aset yang sedang dipinjam.</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                        <label class="col-md-3 control-label">Judul Masalah</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="subject" placeholder="Contoh: Keyboard Macet / Layar Mati" required>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label class="col-md-3 control-label">Detail Kerusakan</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="description" rows="5" placeholder="Jelaskan kronologi atau detail kerusakan..." required></textarea>
                        </div>
                    </div>

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop