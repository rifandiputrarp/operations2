@extends('layouts.app')

@section('title','Verifikasi')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('verifikasi')}}">Verifikasi</a></li>
<li class="breadcrumb-item"><a href="{{url('verifikasi/mulai/'.$penugasan_id)}}">Pelaksanaan</a></li>
<li class="breadcrumb-item active">Laporan</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-file"></i>&nbsp; Lihat Laporan</h3>
            </div>
            <div class="card-body" id="table1_wrapper">
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">Tanggal</small>
                        @if($penugasan[0]->tgl_mulai == $penugasan[0]->tgl_akhir)
                        <h5>{{ date("d/m/Y",strtotime($penugasan[0]->tgl_mulai)) }}</h5>
                        @else
                        <h5>{{ date("d/m/Y",strtotime($penugasan[0]->tgl_mulai)) }} s.d. {{ date("d/m/Y",strtotime($penugasan[0]->tgl_akhir)) }}</h5>
                        @endif
                        <small class="text-muted">Verifikator</small>
                        <h5>
                            {!! $v !!}
                        </h5>
                        <small class="text-muted">ETC</small>
                        <h5>
                            {{$etc}}
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Nama Perusahaan yang Diverifikasi</small>
                        <h5>{!! $penugasan[0]->nama !!}</h5>
                        <small class="text-muted">Peraturan Menteri</small>
                        <h5>
                            {{ $penugasan[0]->nama_permen }}
                            <!-- <br> <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-permen">Edit</a> -->
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <!-- <small class="text-muted">Status</small>
                        <h5><i class="text-default">-</i></h5> -->
                        <small class="text-muted">Jumlah Produk</small>
                        <h5><i class="text-default">{{ $penugasan[0]->jml_produk }}</i></h5>
                        <small class="text-muted">Jumlah Produk yang Telah Diverifikasi</small>
                        <h5><i class="text-default">{{ (int)$jumlahVerify }}</i></h5>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <a href="{{url('laporan/view/'.$penugasan_id)}}" class="btn btn-lg btn-success"><i class="fa fa-plus"></i> Buat Laporan Baru</a>
                </div>
                <table id="table2" class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Laporan</th>
                            <th>No Laporan</th>
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

<div id="previewPDF" class="modal fade text-center">
    <div class="modal-dialog modal-xl" style="height: 100%">
        <div class="modal-content" style="height: 80%">
            <div class="modal-header">
                <h4 class="modal-title">Preview PDF</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="previewIframe" src="">
                    <p>Your browser does not support iframes.</p>
                </iframe>
            </div>
        </div>
    </div>
</div>

<div id="modal-lampiran" class="modal fade text-center">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lampiran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('verifikasi/uploadLampiran')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="laporan_id" name="laporan_id" value="">
                    <div class="form-group row">
                        <label class="col-md-3">Upload File</label>
                        <div class="col-md-9">
                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Keterangan File</label>
                        <div class="col-md-9">
                            <input type="text" name="keterangan" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
                <br>
                <table id="tbl-lamp" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>File</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modal-editdasarhukum" class="modal fade text-center">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Dasar Hukum</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('verifikasi/editDasarHukum')}}" method="POST">
                    @csrf
                    <input type="hidden" id="laporan_id_dasarhukum" name="laporan_id" value="">
                    <div class="form-group row" style="text-align:left">
                        <label class="col-md-3">Dasar Hukum</label>
                        <div class="col-md-9">
                            <textarea id="dasar_hukum" name="dasar_hukum" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@include('layouts.datatable-css')
<style type="text/css">
    #previewIframe {
        width: 100%;
        height: 100%;
    }
</style>
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@push('js')
@include('layouts.datatable-js')
<!-- Summernote -->
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dasar_hukum').summernote({
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
        $('#dasar_hukum').summernote('lineHeights', 2);
    });

    $(function() {

        $("#table2").DataTable({
            "responsive": true,
            "searching": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": false,
            "info": true,
            "paging": true,
            "ajax": {
                "url": "{{ url('verifikasi/getLaporan/'.$penugasan_id) }}",
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "tanggal"
                },
                {
                    "data": "no_laporan"
                },
                {
                    "data": "action"
                },
            ]
        });

        $('#previewPDF').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id')
            var url = button.data('url')
            var modal = $(this)
            $('#previewIframe').attr('src', url);
        });

        $('#modal-lampiran').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id')
            var modal = $(this)
            $('#laporan_id').val(id);
            // tbllamp.ajax.reload();
            tableLamp();
        });

        $('#modal-editdasarhukum').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id')
            var modal = $(this)
            $('#laporan_id_dasarhukum').val(id);

            if ($('#dasar_hukum').summernote('isEmpty')) {} else {
                $('#dasar_hukum').summernote('code', '')
            }

            $.ajax({
                url: "{{url('verifikasi/getDataEdit')}}",
                data: {
                    'laporan_id': id
                }
            }).done(function(m) {
                var obj = JSON.parse(m);
                $('#dasar_hukum').summernote('code', '')
                $('#dasar_hukum').summernote('pasteHTML', obj.dasar_hukum);
            })
        });

        // $("#formLampiran").on("submit", function (e) {
        //     var dataString = $(this).serialize();
        //     $.ajax({
        //       type: "POST",
        //       url: "{{url('verifikasi/uploadLampiran')}}",
        //       data: dataString,
        //       success: function () {
        //         tbllamp.ajax.reload();
        //       }
        //     });
        //     e.preventDefault();
        // });
    });

    function tableLamp() {
        var tbllamp = $('#tbl-lamp').DataTable({
            "responsive": true,
            "searching": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": false,
            "info": true,
            "paging": true,
            "destroy": true,
            "ajax": {
                "url": "{{ url('verifikasi/getLampiran/') }}",
                "data": {
                    "laporan_id": $('#laporan_id').val()
                },
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "nama_file"
                },
                {
                    "data": "keterangan"
                },
                {
                    "data": "action"
                },
            ]
        });
    }
</script>
@endpush