@extends('layouts.app')

@section('title','Surat Tugas')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('tugas')}}">Surat Tugas</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-warning">
            <div class="card-header">
            <h3 class="card-title">List Surat Tugas
            </div>
            <div class="card-body">
                <table id="table1" class="table table-striped table-bordered">
                    <thead class="text-center table-warning">
                        <tr>
                            <th >No</th>
                            <th >No Referensi</th>
                            <th >Nama Perusahaan</th>
                            <th >No Surat Tugas</th>
                            <th >Tanggal Surat Tugas</th>
                            <th >Tanggal Akhir Surat Tugas</th>
                            <th >Nama</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- create surtug -->
<div class="modal fade" id="modal-surtug">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Buat Surat Tugas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{url('surtug/createSurtug')}}" method="post">
            @csrf
            <input type="hidden" id="penugasan_id" name="penugasan_id" value="">
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%">No Surat Tugas</td>
                        <td width="70%">
                            <input type="text" class="form-control col-md-4" name="no_surat" autocomplete="off" value="" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai Surat Tugas</td>
                        <td>
                            <input type="text" class="form-control col-md-4 tanggal" name="tgl_surtug" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Akhir Surat Tugas</td>
                        <td>
                            <input type="text" class="form-control col-md-4 tanggal" name="tgl_akhir_surtug" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Verifikator / ETC <br><small class="badge badge-warning">* Pilih Lebih Dari 1</small></td>
                        <td>
                            <select class="form-control select2bs4" multiple required name="verifikator[]">
                                <option value="">-PILIH-</option>
                                @foreach($verifikator as $key)
                                <option value="{{$key->id}}">{{$key->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </form>
      </div>
    </div>
</div>



<!-- update surtug -->
<div class="modal fade" id="modal-surtug-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Surat Tugas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('surtug/updateSurtug')}}" method="post">
                @csrf
                <input type="hidden" id="penugasan_id" name="penugasan_id" value="">
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">No Surat Tugas</td>
                            <td width="70%">
                                <input type="text" class="form-control col-md-4" name="no_surat" id="no_surat" autocomplete="off" value="" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai Surat Tugas</td>
                            <td>
                                <input type="text" class="form-control col-md-4 tanggal" name="tgl_surtug" id="tgl_surtug" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Akhir Surat Tugas</td>
                            <td>
                                <input type="text" class="form-control col-md-4 tanggal" name="tgl_akhir_surtug" id="tgl_akhir_surtug" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Verifikator / ETC <br><small class="badge badge-warning">* Pilih Lebih Dari 1</small></td>
                            <td>
                                <select class="form-control select2bs4" multiple required name="verifikator[]" id="verifikators">
                                    <option value="">-PILIH-</option>
                                    @foreach($verifikator as $key)
                                        <option value="{{$key->id}}">{{$key->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- info penugasan -->
<div class="modal fade" id="modal-viewpenugasan">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Info Penugasan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <td width="50%">No Referensi</td>
                    <td width="50%" id="no_ref">
                    </td>
                </tr>
                <tr>
                    <td>Nama Perusahaan</td>
                    <td id="nama_perusahaan">
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Mulai Pelaksanaan</td>
                    <td id="tgl_mulai">
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Selesai Pelaksanaan</td>
                    <td id="tgl_akhir">
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Produk yang akan Diverifikasi</td>
                    <td id="jml_produk">
                    </td>
                </tr>
                <tr>
                    <td>PM</td>
                    <td id="pm">
                    </td>
                </tr>
                <tr>
                    <td>Verifikator </td>
                    <td id="verifikator">
                    </td>
                </tr>
                <tr>
                    <td>ETC</td>
                    <td id="etc">
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('css')
<!-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"> -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/bs-stepper/css/bs-stepper.min.css') }}">
@include('layouts.datatable-css')
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
</style>
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
                "url": "{{ url('surtug/getSurtug')}}",
                "dataSrc": ""
            },
            "columns": [
                { "data": "no" },
                { "data": "no_ref" },
                { "data": "nama_perusahaan" },
                { "data": "no_surat" },
                { "data": "tgl_surtug" },
                { "data": "tgl_akhir_surtug" },
                { "data": "name_surtug" },
                { "data": "action" }
            ]
        })
        .buttons()
        .container()
        .appendTo('#table1_wrapper .col-md-6:eq(0)');


        $('#modal-viewpenugasan').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var penugasan_id = button.data('penugasan_id')
          var modal = $(this)
          $.ajax({
            url: "{{url('surtug/getPenugasan')}}",
            data: {"penugasan_id":penugasan_id}
          }).done(function(m){
            var obj = JSON.parse(m);
            modal.find('#no_ref').html(obj.no_ref)
            modal.find('#nama_perusahaan').html(obj.nama)
            modal.find('#tgl_mulai').html(obj.tgl_mulai)
            modal.find('#tgl_akhir').html(obj.tgl_akhir)
            modal.find('#jml_produk').html(obj.jml_produk)
            modal.find('#pm').html(obj.upm)
            modal.find('#verifikator').html(obj.v1)
            modal.find('#etc').html(obj.uetc)
          })
        })

        $('#modal-surtug').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var penugasan_id = button.data('penugasan_id')
          var modal = $(this)
          modal.find('#penugasan_id').val(penugasan_id)

        })

        $('#modal-surtug-edit').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var penugasan_id = button.data('penugasan_id')
          var modal = $(this);
            modal.find('#penugasan_id').val(penugasan_id)
            $.ajax({
                url: "{{url('surtug/getSuratTugas')}}",
                data: {"penugasan_id":penugasan_id}
            }).done(function(m){
                var obj = JSON.parse(m);

                modal.find('#no_surat').val(obj.no_surat)
                modal.find('#tgl_surtug').val(obj.tgl_surtug)
                modal.find('#tgl_akhir_surtug').val(obj.tgl_akhir_surtug)

                var selectedItems = [];
                $.each(obj.detail, function(k, v){
                    selectedItems.push(v.user_id);
                });
                modal.find('#verifikators').val(selectedItems).trigger('change');
            })
        })
    });
</script>
@endpush
