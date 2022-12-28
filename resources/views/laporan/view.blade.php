@extends('layouts.app')

@section('title','Laporan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('verifikasi')}}">Verifikasi</a></li>
<li class="breadcrumb-item"><a href="{{url('verifikasi/mulai/'.$penugasan_id)}}">Pelaksanaan</a></li>
<li class="breadcrumb-item active">Laporan</li>
<li class="breadcrumb-item active">Tambah</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-file"></i>&nbsp; Create Laporan</h3>
            </div>
            <form action="{{url('laporan/createNew')}}" method="POST">
                @csrf
                <input type="hidden" name="penugasan_id" value="{{$penugasan_id}}">
                <div class="card-body" id="table1_wrapper">
                    <div class="form-group row">
                        <label class="col-md-3">No Laporan</label>
                        <div class="col-md-2">
                            <input type="text" name="no_laporan" class="form-control" value="AUTO" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Tanggal Laporan</label>
                        <div class="col-md-2">
                            <input type="text" required class="form-control tanggal" data-toggle="datetimepicker" name="tgl_laporan" placeholder="DD/MM/YYYY" autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">Dasar Hukum</label>
                        <div class="col-md-9">
                            <textarea id="summernote" name="dasar_hukum" rows="5">{!! $permen->dasar_hukum !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">Data produk yang telah diverifikasi</label>
                        <div class="col-md-1">
                            <input type="checkbox" class="form-control" onClick="toggle(this)" /><br />
                        </div>
                        <label class="col-md-3">Check / Uncheck All</label>
                    </div>
                    <table id="table1" class="table table-striped table-bordered" style="width:100%">

                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Kelompok Barang/Jasa</th>
                                <th>Jenis Industri</th>
                                <th>Jenis Produk</th>
                                <th>Tipe</th>
                                <th>Spesifikasi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="table1-body">
                        </tbody>
                    </table>

                </div>
                <div class="card-footer">
                    <button class="btn btn-lg btn-success"><i class="fa fa-print"></i> Create Laporan</button>
                    <button class="btn btn-lg btn-info float-right" formaction="{{url('cetak-laporan/0/previewDraft')}}"><i class="fa fa-file-pdf"></i> Preview</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('css')
@include('layouts.datatable-css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">

@endpush

@push('js')
@include('layouts.datatable-js')
<!-- Summernote -->
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 150,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                // ['font', ['fontname']],
                // ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
            // fontNames: ['Arial'],
            lineHeights: ['2.0']
        });
        $('#summernote').summernote('lineHeights', 2);

    });

    var table_upload = $('#table-upload').DataTable();
    $(function() {

        var table1;
        getTable1();

        $(document).on("click", ".btn-modal-upload", function() {
            var produk_id = $(this).data('produk_id');
            $("#modal-upload #ver_produk_id").val(produk_id);
            table_upload.destroy();
            tableUpload(produk_id)
            // it is unnecessary to have to manually call the modal.
            // $('#addBookDialog').modal('show');
        });
    });

    function getTable1() {
        penugasan_id = "{{$penugasan_id}}";
        $("#table1-body").empty();
        $("#table1").DataTable({
            "responsive": true,
            "searching": false,
            "lengthChange": false,
            "autoWidth": false,
            "lengthChange": false,
            "ordering": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ajax": {
                "url": "{{ url('verifikasi/getDataVerProduk2') }}",
                "data": {
                    'id': penugasan_id
                }
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "kelompok"
                },
                {
                    "data": "bidang_usaha"
                },
                {
                    "data": "jenis_produk"
                },
                {
                    "data": "tipe"
                },
                {
                    "data": "spesifikasi"
                },
                // { "data": "file" },
                // { "data": "status" },
                {
                    "data": "action"
                }
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 1
            }],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ]
        });
    }

    function tableUpload(ver_produk_id) {
        penugasan_id = $('#penugasan_id').val();
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
                    'id': penugasan_id,
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
                    "data": "status"
                },
            ]
        });
    }

    function gantiSurtug() {
        getTable1();
    }

    function toggle(source) {
        checkboxes = document.getElementsByName('produk_id[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
@endpush