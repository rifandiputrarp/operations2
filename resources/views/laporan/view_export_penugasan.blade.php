@extends('layouts.app')

@section('title','Export Data')

@section('breadcrumb')
<li class="breadcrumb-item active">Export Data Verifikasi</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-file"></i>&nbsp; Data Total Produk</h3>
            </div>
            <form action="{{url('doExportData')}}" method="POST">
                @csrf
                <div class="card-body" id="table1_wrapper">
                    <div class="form-group row">
                        <label class="col-md-2">Tanggal Mulai</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control col-md-8 tanggal" name="tgl_awal" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </div>
                        <label class="col-md-2">Tanggal Akhir</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control col-md-8 tanggal" name="tgl_akhir" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </div>
                    </div>
                    {{--<table id="table2" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Perusahaan</th>
                                <th>Alamat</th>
                                <th>Nomor OC</th>
                                <th>Nomor Ref</th>
                                <th>Status Berbayar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>--}}
                    @role('Admin|Verifikator|ETC')
                    <div class="form-group">
                        <label class="col-md-3"></label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                    </div>
                    @endrole
                </div>


            </form>
        </div>
    <!-- /.card -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-file"></i>&nbsp; Database </h3>
            </div>
            <form action="{{url('doExportDataBase')}}" method="POST">
                @csrf
                <div class="card-body" id="table1_wrapper">
                    <div class="form-group row">
                        <label class="col-md-2">Tanggal Mulai</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control col-md-8 tanggal" name="tgl_awal" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </div>
                        <label class="col-md-2">Tanggal Akhir</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control col-md-8 tanggal" name="tgl_akhir" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </div>
                    </div>
                    @role('Admin|Verifikator|ETC')
                    <div class="form-group">
                        <label class="col-md-3"></label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                    </div>
                    @endrole
                </div>


            </form>
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
var table_upload = $('#table-upload').DataTable();
$(function () {

    $("#table2").DataTable({
        "responsive": true,
        "searching": true,
        "lengthChange": true,
        "autoWidth": false,
        "ordering": false,
        "info": true,
        "paging": true,
        "ajax": {
            "url": "{{ url('laporan/getData') }}",
        },
        "columns": [
            { "data": "no" },
            { "data": "no_ref" },
            { "data": "no_laporan" },
            { "data": "tanggal" },
            { "data": "nama_perusahaan" },
            { "data": "name" },
            { "data": "action" },
        ]
    });

    $(document).on("click", ".btn-modal-upload", function () {
        var produk_id = $(this).data('produk_id');
        $("#modal-upload #ver_produk_id").val( produk_id );
        table_upload.destroy();
        tableUpload(produk_id)
         // it is unnecessary to have to manually call the modal.
         // $('#addBookDialog').modal('show');
    });
});

function validateType(objFileControl) {
    var file = objFileControl.value;
    var name = objFileControl.name;
    var len = file.length;
    var ext = file.slice(len - 4, len);

    if (ext.toUpperCase() != ".PDF" && ext.toUpperCase() != ".JPG" && ext.toUpperCase() != ".PNG") {
        alert("Dokumen yang dapat diunggah adalah PDF/PNG/JPG");
        $('input[name='+name+']').val("");
    }
    validateSize(objFileControl)
}

function validateSize(file) {
    var FileSize = file.files[0].size / 1024 / 1024; // in MB
    var name = file.name;
    if (FileSize > 5) {
        alert('Maksimum ukuran dokumen yang dapat diunggah adalah 5 MB');
        $(`input[name="${name}"]`).val("");
    }
}

function tesnil(data){
    $('#dataId').val(data)
}
</script>
@endpush
