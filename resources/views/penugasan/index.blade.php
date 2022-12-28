@extends('layouts.app')

@section('title','Penugasan Verifikator')

@section('breadcrumb')
<li class="breadcrumb-item active">Penugasan Verifikator</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Penugasan Verifikator</h3>
            </div>
            <div class="card-body" id="table1_wrapper">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status" onchange="gettable()">
                        <option value="1">Belum Ditugaskan</option>
                        <option value="2">Semua Status</option>
                    </select>
                </div>
                <table id="table1" class="table table-striped table-bordered">
                    <thead class="table-info text-center">
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama Perusahaan<br><small>(klik di nama perusahaan untuk detil)</small></th>
                            <th rowspan="2">Nomor OC</th>
                            <th rowspan="2">Berbayar?</th>
                            <th colspan="2">Jumlah Produk</th>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>Telah Ditugaskan</th>
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
    var table1 ;
    $( document ).ready(function() {
        gettable();
    });

  function gettable(){
        status = $('#status').val();
        table1 = $("#table1").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "destroy": true,
            "ajax": {
                "url": "{{ url('tugas/getData') }}",
                "dataSrc": "",
                "data": {"status":status}
            },
            "columns": [
                { "data": "no" },
                { "data": "nama" },
                { "data": "no_oc" },
                { "data": "berbayar" },
                { "data": "objek_order" },
                { "data": "jml_produk" },
            ]
        })
    }
</script>
@endpush
