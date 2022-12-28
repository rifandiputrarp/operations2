@extends('layouts.app')

@section('title','Status Sertifikasi Perusahaan Penyedia Barang')

@section('breadcrumb')
<li class="breadcrumb-item active">Status Sertifikasi Perusahaan Penyedia Barang</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Daftar Perusahaan Penyedia Barang</h3>
            </div>
            <div class="card-body">
                <div class="container" style="overflow: auto;max-width:100%">
                    <table id="example" class="table table-striped table-bordered datatable">
                        <thead>
                            <tr>
                                <th> No </th>
                                <th> Nama Perusahaan </th>
                                <th> Alamat Perusahaan </th>
                                <th> Status Sertifikat </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('additionalScripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('status-sertifikat-barang/getDataBarang') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'alamat_pusat',
                    name: 'alamat_pusat',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });

</script>
@endsection

@endsection