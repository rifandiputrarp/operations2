@extends('layouts.app')

@section('title','Laporan')

@section('breadcrumb')
<li class="breadcrumb-item active">Laporan</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-file"></i>&nbsp; Laporan</h3>
            </div>
            <div class="card-body" id="table1_wrapper">
                <table id="table2" class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>No Referensi</th>
                            <th>No Laporan</th>
                            <th>Tanggal Laporan</th>
                            <th>Nama Perusahaan</th>
                            <th>Cover</th>
                            <th>No Sertifikat</th>
                            <!-- <th>Jumlah Produk</th> -->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    <!-- /.card -->
    </div>
</div>

<div class="modal fade" id="modal-surtug">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Cover</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('laporan/cover')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3">Cover</label>
                        <div class="col-md-9">
                            <input type="hidden" id="dataId" name="id">
                            <input type="file" name="cover" class="form-control" onchange="validateType(this)" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-upload-sertifikat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Sertifikat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('laporan/sertifikat')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3">No Sertfiikat</label>
                        <div class="col-md-9">
                            <input type="text" id="no_sertifikat" name="no_sertifikat" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">File Sertifikat</label>
                        <div class="col-md-9">
                            <input type="hidden" id="idData" name="id">
                            <input type="file" name="file_sertifikat" class="form-control" onchange="validateType(this)" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
            { "data": "no_sertifikat" },
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

function setVal(data, no_sertifikat){
    $('#idData').val(data);
    $('#no_sertifikat').val(no_sertifikat);
}


function delete_sertifikat(id, no_sertifikat)
{
    event.preventDefault();
    Swal.fire({
        title: 'Yakin hapus sertifikat '+no_sertifikat+' ?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ url('laporan/deleteSertifikat/') }}/'+id;
        }
    })
}

</script>
@endpush
