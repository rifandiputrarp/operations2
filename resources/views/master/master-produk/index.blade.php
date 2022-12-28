@extends('layouts.app')

@section('title','Master Produk')

@section('breadcrumb')
<li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Daftar Produk</h3>
            </div>
            <div class="card-body">
                <a href="{{ url('master-produk/tambah') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data</a>
                <br><br>
                <table id="table1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kode Permen</th>
                            <th>Action</th>
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
@endsection

@push('css')
    @include('layouts.datatable-css')
@endpush

@push('js')
    @include('layouts.datatable-js')
    <script>
    $(function () {
        $("#table1").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "ajax": {
                "url": "{{ url('master-produk/getList') }}",
                "dataSrc": ""
            },
            "columns": [
                { "data": "no" },
                { "data": "nama_produk" },
                { "data": "kode_permen" },
                { "data": "action" }
            ]
        })
        .buttons()
        .container()
        .appendTo('#table1_wrapper .col-md-6:eq(0)');
    });
    </script>
@endpush