@extends('layouts.app')

@section('title','Master Perusahaan')

@section('breadcrumb')
<li class="breadcrumb-item active">Master Perusahaan</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">File Master Perusahaan</h3>
                </div>
                <div class="card-body">
                    <div class="bs-stepper">
                            <div class="form-group" style="margin-bottom:30px">
                                <label>Badan Perusahaan*</label>
                                <input class="form-control col-md-2" list="list_badan" name="badan" id="badan" value="{{@$data_perusahaan[0]->badan}}" autocomplete="off" disabled>
                            </div>

                            <div class="form-group" style="margin-bottom:30px">
                                <label>Nama Perusahaan</label>
                                <input type="text" class="form-control" placeholder="Nama Perusahaan" name="nama" value="{{@$data_perusahaan[0]->nama}}" required disabled>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <form method="POST" action="{{ url('master-perusahaan/uploadFile') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_perusahaan" value="{{$id}}">
                    <div class="form-group row">
                        <label class="col-md-3">Keterangan File</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control"  value="" id="keterangan" name="keterangan" required>
                        </div>
                    </div>
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
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/bs-stepper/css/bs-stepper.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    hr.hr-text {
        position: relative;
        border: none;
        height: 1px;
        background: #999;
        margin-top: 10px;
    }

    hr.hr-text::before {
        content: attr(data-content);
        display: inline-block;
        background: #fff;
        font-weight: bold;
        font-size: 1rem;
        color: #999;
        border-radius: 30rem;
        padding: 0.2rem 2rem;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px !important;
    }
</style>
@endpush

@push('css')
    @include('layouts.datatable-css')
@endpush

@push('js')
    @include('layouts.datatable-js')
    <script>
        $(function () {
            var id_perusahaan = "{{$id}}";
            var table_upload = $('#table-upload').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "ajax": {
                    "url": "{{ url('master-perusahaan/getFile') }}",
                    "data": {'id_perusahaan':id_perusahaan}
                },
                "columns": [
                    { "data": "no" },
                    { "data": "nama_file" },
                    { "data": "keterangan" },
                @role('Admin|Verifikator|ETC')
                    { "data": "action" },
                @endrole
                ]
            });
        })

        function change_kbl(val){
            if(val!=null && val!=""){
                $("#file_perhitungan").show();
            }else{
                $("#file_perhitungan").hide();
            }
        }

    </script>
@endpush
