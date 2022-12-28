@extends('layouts.app')

@section('title','Verifikasi')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('verifikasi')}}">Verifikasi</a></li>
<li class="breadcrumb-item"><a href="{{url('verifikasi/mulai/'.$verProduk[0]->penugasan_id)}}">Pelaksanaan</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection


@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Data Produk</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{url('verifikasi/prosesEditProduk')}}" method="POST">
          @csrf
          <input type="hidden" name="penugasan_id" value="{{$verProduk[0]->penugasan_id}}">
          <input type="hidden" name="ver_produk_id" value="{{$verProduk[0]->id}}">
          <div class="form-group row">
            <label class="col-md-2">Kelompok Barang/Jasa</label>
            <div class="col-md-4">
              <select class="form-control" id="kelompok_id" name="kelompok_id" required>
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
            <label class="col-md-2">Bidang Usaha</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->bidang_usaha != '') {{$verProduk[0]->bidang_usaha}} @else - @endif" id="bidang_usaha" name="bidang_usaha">
            </div>
          </div>
          <div class="form-group row">
            @if($permen_id != 3)
            <label class="col-md-2">Jenis Produk</label>
            @else
            <label class="col-md-2">Kategori Produk</label>
            @endif
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->jenis_produk != '') {{$verProduk[0]->jenis_produk}} @else - @endif" id="jenis_produk" name="jenis_produk">
            </div>
            @if($permen_id != 3)
            <label class="col-md-2">Tipe</label>
            @else
            <label class="col-md-2">Bentuk Sediaan</label>
            @endif
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->tipe != '') {{$verProduk[0]->tipe}} @else - @endif" id="tipe" name="tipe">
            </div>
          </div>
          <div class="form-group row">
            @if($permen_id != 3)
            <label class="col-md-2">Spesifikasi</label>
            @else
            <label class="col-md-2">Kemasan</label>
            @endif
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->spesifikasi != '') {{$verProduk[0]->spesifikasi}} @else - @endif" id="spesifikasi" name="spesifikasi">
            </div>
            @if($permen_id != 3)
            <label class="col-md-2">Merk</label>
            @else
            <label class="col-md-2">Nama Obat</label>
            @endif
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->merk != '') {{$verProduk[0]->merk}} @else - @endif" id="merk" name="merk">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2">Kode HS</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->kode_hs != '') {{$verProduk[0]->kode_hs}} @else - @endif" id="kode_hs" name="kode_hs">
            </div>
            <label class="col-md-2">NIE</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->nie != '') {{$verProduk[0]->nie}} @else - @endif" id="nie" name="nie">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2">Standar Produk</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->standar_produk != '') {{$verProduk[0]->standar_produk}} @else - @endif" id="standar_produk" name="standar_produk">
            </div>
            <label class="col-md-2">Sertifikat Produk</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->sertifikat_produk != '') {{$verProduk[0]->sertifikat_produk}} @else - @endif" id="sertifikat_produk" name="sertifikat_produk">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2">Kapasitas Produksi Izin</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->kapasitas_izin != '') {{$verProduk[0]->kapasitas_izin}} @else - @endif" id="kapasitas_izin" name="kapasitas_izin">
            </div>
            <label class="col-md-2">Kapasitas Produksi Sesuai VKI</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->kapasitas_vki != '') {{$verProduk[0]->kapasitas_vki}} @else - @endif" id="kapasitas_vki" name="kapasitas_vki">
            </div>
          </div>
          @if($permen_id == 3 || $permen_id == 4 || $permen_id == 5)
          <div class="form-group row">
            <label class="col-md-2">Nomor Persetujuan</label>
            <div class="col-md-4">
              <input type="text" class="form-control" value="@if($verProduk[0]->nomor_persetujuan != ''){{$verProduk[0]->nomor_persetujuan}}@endif" id="nomor_persetujuan" name="nomor_persetujuan">
            </div>
          </div>
          @endif


          @role('Admin|Verifikator|ETC')
          <div class="form-group">
            <label class="col-md-3"></label>
            <div class="col-md-9">
              <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
          </div>
          @endrole
        </form>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">File Perhitungan</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @role('Admin|Verifikator|ETC')
        <!-- download template -->
        <div class="form-group row">
          <label class="col-md-3">Template</label>
          <div class="col-md-9">
            <a href="{{ url('verifikasi/download/'.$permen_id) }}" class="btn btn-sm btn-success text-left"><i class="fa fa-download"></i>&nbsp; Download Template</a>
          </div>
        </div>
        <form method="POST" action="{{ url('verifikasi/uploadExcel') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="penugasan_id" value="{{$verProduk[0]->penugasan_id}}">
          <input type="hidden" name="ver_produk_id" value="{{$verProduk[0]->id}}">
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
        @endrole
        <table id="table-upload" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama File</th>
              <th>Capaian TKDN (%)</th>
              @role('Admin|Verifikator|ETC')
              <th>Action</th>
              @endrole
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- <div class="col-12">
        <div class="card card-success card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3"><h3 class="card-title">View Form</h3></li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab1" data-toggle="pill" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">Form 1.1</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab2" data-toggle="pill" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Form 1.2</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab3" data-toggle="pill" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Form 1.3</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab4" data-toggle="pill" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true">Form 1.4</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab5" data-toggle="pill" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true">Form 1.5</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab6" data-toggle="pill" href="#tab6" role="tab" aria-controls="tab6" aria-selected="true">Form 1.6</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab7" data-toggle="pill" href="#tab7" role="tab" aria-controls="tab7" aria-selected="true">Form 1.7</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="btn-tab8" data-toggle="pill" href="#tab8" role="tab" aria-controls="tab8" aria-selected="true">Form 1.8</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="btn-tab9" data-toggle="pill" href="#tab9" role="tab" aria-controls="tab9" aria-selected="true">Form 1.9</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
              <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="btn-tab1">

              </div>
              <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="btn-tab2">

              </div>
              <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="btn-tab3">

              </div>
              <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="btn-tab4">

              </div>
              <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="btn-tab5">

              </div>
              <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="btn-tab6">

              </div>
              <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="btn-tab7">

              </div>
              <div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="btn-tab8">

              </div>
              <div class="tab-pane fade active show" id="tab9" role="tabpanel" aria-labelledby="btn-tab9">

              </div>
            </div>
          </div>
        </div>
    </div> -->
</div>

@endsection

@push('css')
@include('layouts.datatable-css')
@endpush

@push('js')
@include('layouts.datatable-js')
<script>
  $(function() {
    ver_produk_id = "{{$verProduk[0]->id}}";
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
        "data": {
          'ver_produk_id': ver_produk_id
        }
      },
      "columns": [{
          "data": "no"
        },
        {
          "data": "nama_file"
        },
        {
          "data": "capaian_tkdn"
        },
        @role('Admin|Verifikator|ETC') {
          "data": "action"
        },
        @endrole
      ]
    });
  })
</script>
@endpush