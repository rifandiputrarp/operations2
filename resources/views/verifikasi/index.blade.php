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
                <table id="table1" class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-center table-primary" >
                        <tr>
                            <th>No</th>
                            <th>No Ref</th>
                            <th>Nama Perusahaan <br><small>(klik perusahaan untuk detil)</small></th>
                            <th width="5%">Peraturan Menteri</th>
                            <th>Tanggal</th>
                            <th>Verifikator & ETC</th>
                            <th>Jumlah Produk</th>
                            <!-- <th></th> -->
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


<!-- modul edit permen -->
<div class="modal fade" id="modal-permen">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Peraturan Menteri</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formPermen" method="post">
            @csrf
            <input type="hidden" id="penugas_id" name="penugas_id" value="">
            <div class="modal-body">
              <div class="form-group row">
                <label class="col-md-3">Peraturan Menteri</label>
                <div class="col-md-9">
                    <select class="form-control" name="permen_id" required>
                        <option value="">-PILIH-</option>
                        @foreach($permen as $key)
                        <option value="{{$key->id}}">{{$key->nama_permen}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary float-right">Simpan</button>
            </div>
        </form>
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
    var table1 = $("#table1").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
      "destroy": true,
      "ajax": {
            "url": "{{ url('verifikasi/getDataSurtug')}}",
            "dataSrc": ""
        },
        "columns": [
            { "data": "no" },
            { "data": "no_ref" },
            { "data": "nama_perusahaan" },
            { "data": "nama_permen" },
            { "data": "tgl" },
            { "data": "verifikator" },
            { "data": "jml_produk" },
            // { "data": "action" }
        ]
      // "buttons": ["copy", "csv", "excel", "colvis"]
    })
    // .buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#modal-permen').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var penugas_id = button.data('penugas_id') 
      var modal = $(this)
      $('#penugas_id').val(penugas_id);
    });

    $("#formPermen").on("submit", function (e) {
        var dataString = $(this).serialize();
        
        $.ajax({
          type: "POST",
          url: "{{url('verifikasi/simpan_permen')}}",
          data: dataString,
          success: function () {
            $('#modal-permen').modal('toggle');
            table1.ajax.reload();
          }
        });

        e.preventDefault();
    });

  });

  function alertPermen(){
    Swal.fire({
      icon: 'info',
      title: 'Info!',
      text: 'Mohon pilih Peraturan Menteri terlebih dahulu',
      // footer: '<a href="">Why do I have this issue?</a>'
    })
  }
</script>
@endpush
