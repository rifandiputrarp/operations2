@extends('layouts.app')

@section('title','Verifikasi')

@section('breadcrumb')
<li class="breadcrumb-item active">Verifikasi</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Verifikasi</h3>
            </div>
            <div class="card-body" id="example1_wrapper">
            	<div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">Tanggal</small>
                        <h5>08/09/2021</h5>
                        <small class="text-muted">Verifikator</small>
                        <h5><b>TAUFIK</b>, <b>RENALDY</b>, <b>ACIL</b></h5>
                        <small class="text-muted">ETC</small>
                        <h5><b>DYDI PURWANTO</b></h5>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Status</small>
                        <h5><i class="text-default">Open</i> &nbsp; <a href="#" class="btn btn-sm btn-danger">Close!</a></h5>
                        <small class="text-muted">Jumlah Produk</small>
                        <h5><i class="text-default">6</i></h5>
                        <small class="text-muted">Jumlah Produk yang Telah Diverifikasi</small>
                        <h5><i class="text-default">4</i></h5>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Nama Perusahaan</small>
                        <h5>PT. Inter Persada Utama</h5>
                        <small class="text-muted">Alamat</small>
                        <h5>Wisma Laena 3rd Floor Suite 310, Jl. KH. Abdullah Syafe’i Jakarta Selatan</h5>
                        <small class="text-muted">Permen</small>
                        <h5>{{$permen}}</h5>
                    </div>
                </div>
                <br>
                
                <table id="table1" class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Kelompok Barang/Jasa</th>
                            <th>Bidang Usaha</th>
                            <th>Jenis Produk</th>
                            <th>Tipe</th>
                            <th>Spesifikasi</th>
                            <th>File</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>-</td>
                            <td>-</td>
                            <td>LED TV COOCAA</td>
                            <td>32S7G</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i><span class="badge badge-warning">Belum Diverifikasi</span></i></td>
                            <td class="">
                                <div class="btn-group-vertical ">
                                    <a href="{{url('verifikasi/download/'.$permen_id)}}" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-download"></i>&nbsp; Download</a>
                                    <a href="#" class="btn btn-sm btn-outline-success text-left" data-toggle="modal" data-target="#modal-upload"><i class="fa fa-upload"></i>&nbsp; Upload</a>
                                    <a href="{{url('verifikasi/view/1')}}" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-list"></i>&nbsp; View</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-editproduk" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-pencil"></i>&nbsp; Edit Produk</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>-</td>
                            <td>-</td>
                            <td>LED TV COOCAA</td>
                            <td>40S7G</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i><span class="badge badge-warning">Belum Diverifikasi</span></i></td>
                            <td class="">
                                <div class="btn-group-vertical ">
                                    <a href="{{url('verifikasi/download/'.$permen_id)}}" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-download"></i>&nbsp; Download</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-upload" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-upload"></i>&nbsp; Upload</a>
                                    <a href="{{url('verifikasi/view/2')}}" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-list"></i>&nbsp; View</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-editproduk" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-pencil"></i>&nbsp; Edit Produk</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>-</td>
                            <td>-</td>
                            <td>LED TV COOCAA</td>
                            <td>32CTD6500</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i><span class="badge badge-warning">Belum Diverifikasi</span></i></td>
                            <td class="">
                                <div class="btn-group-vertical ">
                                    <a href="{{url('verifikasi/download/'.$permen_id)}}" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-download"></i>&nbsp; Download</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-upload" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-upload"></i>&nbsp; Upload</a>
                                    <a href="{{url('verifikasi/view/3')}}" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-list"></i>&nbsp; View</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-editproduk" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-pencil"></i>&nbsp; Edit Produk</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>-</td>
                            <td>-</td>
                            <td>LED TV COOCAA</td>
                            <td>40CTD6500</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i><span class="badge badge-warning">Belum Diverifikasi</span></i></td>
                            <td class="">
                                <div class="btn-group-vertical ">
                                    <a href="{{url('verifikasi/download/'.$permen_id)}}" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-download"></i>&nbsp; Download</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-upload" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-upload"></i>&nbsp; Upload</a>
                                    <a href="{{url('verifikasi/view/4')}}" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-list"></i>&nbsp; View</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-editproduk" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-pencil"></i>&nbsp; Edit Produk</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>-</td>
                            <td>-</td>
                            <td>LED TV COOCAA</td>
                            <td>24CTD2000</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i><span class="badge badge-warning">Belum Diverifikasi</span></i></td>
                            <td class="">
                                <div class="btn-group-vertical ">
                                    <a href="{{url('verifikasi/download/'.$permen_id)}}" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-download"></i>&nbsp; Download</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-upload" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-upload"></i>&nbsp; Upload</a>
                                    <a href="{{url('verifikasi/view/5')}}" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-list"></i>&nbsp; View</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-editproduk" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-pencil"></i>&nbsp; Edit Produk</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>-</td>
                            <td>-</td>
                            <td>LED TV COOCAA</td>
                            <td>24D5T</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i><span class="badge badge-warning">Belum Diverifikasi</span></i></td>
                            <td class="">
                                <div class="btn-group-vertical ">
                                    <a href="{{url('verifikasi/download/'.$permen_id)}}" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-download"></i>&nbsp; Download</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-upload" class="btn btn-sm btn-outline-success text-left"><i class="fa fa-upload"></i>&nbsp; Upload</a>
                                    <a href="{{url('verifikasi/view/6')}}" class="btn btn-sm btn-outline-dark text-left"><i class="fa fa-list"></i>&nbsp; View</a>
                                    <a href="#" data-toggle="modal" data-target="#modal-editproduk" class="btn btn-sm btn-outline-dark text-left" data-toggle="modal" data-target="#modal-editproduk"><i class="fa fa-pencil"></i>&nbsp; Edit Produk</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <!-- /.card -->
    </div>
</div>

<div class="modal fade" id="modal-editproduk">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Edit Produk</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <div class="form-group row">
	      	<label class="col-md-3">Kelompok Barang/Jasa</label>
	      	<div class="col-md-9">
	      		<select class="form-control">
	      			<option value="">-PILIH-</option>
	      			@foreach($kelompok as $key)
	      			<option value="{{$key->id}}">{{$key->nama}}</option>
	      			@endforeach
	      		</select>
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Bidang Usaha</label>
	      	<div class="col-md-9">
	      		<select class="form-control">
	      			<option value="">-PILIH-</option>
	      		</select>
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Jenis Produk</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" value="LED TV COOCAA" name="">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Tipe</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" value="32S7G" name="">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Spesifikasi</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" name="">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Merek</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" name="">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Standar Produk</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" name="">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Sertifikat Produk</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" name="">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Kapasitas Produksi Ijin</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" name="">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3">Kapasitas Produksi Sesuai VKI</label>
	      	<div class="col-md-9">
	      		<input type="text" class="form-control" name="">
	      	</div>
	      </div>
	    </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      <button type="button" class="btn btn-primary">Save changes</button>
	    </div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-upload">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Upload Form Excel</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <div class="form-group row">
	      	<label class="col-md-3">File</label>
	      	<div class="col-md-9">
	      		<input type="file" name="" class="form-control">
	      	</div>
	      </div>
	      <div class="form-group row">
	      	<label class="col-md-3"></label>
	      	<div class="col-md-9">
	      		<button type="button" class="btn btn-primary">Simpan</button>
	      	</div>
	      </div>
	      <br>
	      	<table id="table-upload" class="table table-bordered" style="width:100%">
	      		<thead>
	      			<tr>
	      				<th>No</th>
	      				<th>Nama File</th>
	      				<th>Action</th>
	      			</tr>
	      		</thead>
	      		<tbody></tbody>
	      	</table>
	    </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@push('css')
@include('layouts.datatable-css')
@endpush

@push('js')
@include('layouts.datatable-js')
<script>
  $(function () {
    // $("#table1").DataTable({
    //   "responsive": true, 
    //   "lengthChange": true, 
    //   "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "colvis"]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#table1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
    $('#table-upload').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
@endpush
