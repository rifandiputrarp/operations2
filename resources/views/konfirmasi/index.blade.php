@extends('layouts.app')

@section('title','Konfirmasi Order')

@section('breadcrumb')
<li class="breadcrumb-item active">Konfirmasi Order</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">List Konfirmasi Order</h3>
            </div>
            <div class="card-body">
                <a href="{{ url('konfirmasi-order/tambah') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Konfirmasi Order</a>
                <br><br>
                <table id="table1" class="table table-striped table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nomor OC</th>
                            <th>Tanggal</th>
                            <th>Perusahaan yang Diverifikasi</th>
                            <th>Jumlah Produk</th>
                            <th>Berbayar?</th>
                            <th>Status Approval</th>
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
<style>
    ul.timeline {
        list-style-type: none;
        position: relative;
    }
    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: -6px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }
    ul.timeline > li {
        margin: 20px 0;
        padding-left: 20px;
    }
    ul.timeline > li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #22c0e8;
        left: -14px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }

    ul.timeline > li.passed:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #808080;
        left: -14px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }

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
</style>
@endpush

@push('js')
@include('layouts.datatable-js')
<script>
   $(function () {
        $("#table1").DataTable({
            responsive: true, 
            lengthChange: true, 
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            ajax: "{{ url('konfirmasiorder/getList') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nomor', name: 'nomor'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nama', name: 'nama'},
                {data: 'objek_order', name: 'objek_order'},
                {data: 'berbayar', name: 'berbayar'},
                {data: 'status', name: 'status'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        })
        .buttons()
        .container()
        .appendTo('#table1_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush
