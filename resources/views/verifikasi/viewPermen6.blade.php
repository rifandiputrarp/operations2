@extends('layouts.app')

@section('title','Verifikasi')

@section('breadcrumb')
<li class="breadcrumb-item active">Verifikasi</li>
@endsection


@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Produk</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{url('verifikasi/prosesEditProduk/detail')}}" method="POST">
                    @csrf
                <input type="hidden" name="surat_tugas_id" value="{{ $verProduk[0]->surat_tugas_id }}">
                <input type="hidden" name="ver_produk_id" value="{{ $verProduk[0]->id }}">
              <div class="form-group row">
                <label class="col-md-3">Kelompok Barang/Jasa</label>
                <div class="col-md-9">
                    <select class="form-control" required id="kelompok_id" name="kelompok_id">
                        <option value="">-PILIH-</option>
                        @foreach($kelompok as $key)
                            @if($key->id == $verProduk[0]->kelompok_id)
                            <option selected value="{{$key->id}}">{{$key->nama}}</option>
                            @else
                            <option value="{{$key->id}}">{{$key->nama}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Bidang Usaha</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" required value="{{$verProduk[0]->bidang_usaha}}" id="bidang_usaha" name="bidang_usaha">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Jenis Produk</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" required value="{{$verProduk[0]->jenis_produk}}" id="jenis_produk" name="jenis_produk">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Tipe</label>
                <div class="col-md-9">
                    <input type="text" class="form-control"  required value="{{$verProduk[0]->tipe}}" id="tipe" name="tipe">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Spesifikasi</label>
                <div class="col-md-9">
                    <input type="text" class="form-control"  required value="{{$verProduk[0]->spesifikasi}}" id="spesifikasi" name="spesifikasi">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Merek</label>
                <div class="col-md-9">
                    <input type="text" class="form-control"  required value="{{$verProduk[0]->merk}}" id="merk" name="merk">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Standar Produk</label>
                <div class="col-md-9">
                    <input type="text" class="form-control"  required value="{{$verProduk[0]->standar_produk}}" id="standar_produk" name="standar_produk">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Sertifikat Produk</label>
                <div class="col-md-9">
                    <input type="text" class="form-control"  required value="{{$verProduk[0]->sertifikat_produk}}" id="sertifikat_produk" name="sertifikat_produk">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Kapasitas Produksi Izin</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" required value="{{$verProduk[0]->kapasitas_izin}}" id="kapasitas_izin" name="kapasitas_izin">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3">Kapasitas Produksi Sesuai VKI</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" required value="{{$verProduk[0]->kapasitas_vki}}" id="kapasitas_vki" name="kapasitas_vki">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3"></label>
                <div class="col-md-9">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
              </div>
            </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">File Perhitungan</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                <label class="col-md-3">Template</label>
                <div class="col-md-9">
                    <a href="{{ url('verifikasi/download/'.$permen_id) }}" class="btn btn-sm btn-success text-left"><i class="fa fa-download"></i>&nbsp; Download Template</a>
                </div>
            </div>
            <form method="POST" action="{{ url('verifikasi/uploadExcel') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="surat_tugas_id" value="{{$verProduk[0]->surat_tugas_id}}">
            <input type="hidden" id="ver_produk_id" name="ver_produk_id" value="{{$verProduk[0]->id}}">
            <div class="form-group row">
                <label class="col-md-3">File</label>
                <div class="col-md-9">
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3"></label>
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
            <table id="table-upload" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@include('layouts.datatable-css')
@endpush

@push('js')
@include('layouts.datatable-js')
<script>
$(function () {
    ver_produk_id = 1
    var table_upload = $('#table-upload').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "ajax": {
            "url": "{{ url('verifikasi/getExcelProduk') }}",
            "data": {'id':'1','ver_produk_id':ver_produk_id}
        },
        "columns": [
            { "data": "no" },
            { "data": "nama_file" },
            { "data": "status" },
            { "data": "action" },
        ]
    });
})
</script>
@endpush
