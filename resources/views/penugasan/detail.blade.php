@extends('layouts.app')

@section('title','Penugasan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('tugas')}}">Penugasan</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
            <h3 class="card-title">Detail Penugasan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">Nomor OC</small>
                        <h5> {{$oc[0]->nomor}}</h5>
                        <small class="text-muted">Nama Perusahaan</small>
                        <h5> {!! $oc[0]->nama !!}</h5>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Total Produk</small>
                        <h5>  {{$oc[0]->objek_order}}</h5>
                        <small class="text-muted">Waktu Pelaksanaan</small>
                        <h5>  {{$oc[0]->waktu_pelaksanaan}} Hari</h5>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#modal-surtug"><i class="fa fa-plus"></i> Buat Penugasan</a>
                    </div>
                </div>

                <br>
                <table id="table1" class="table table-striped table-bordered">
                    <thead class="text-center table-info">
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">No Referensi</th>
                            <th colspan="2">Tanggal</th>
                            <th rowspan="2">PM</th>
                            <th rowspan="2">Verifikator</th>
                            <th rowspan="2">ETC</th>
                            <th rowspan="2" style="width: 50px">Jumlah Produk Ditugaskan</th>
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr>
                            <th>Mulai</th>
                            <th>Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-surtug">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Buat Penugasan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{url('penugasan/createSurtug')}}" method="post">
            @csrf
            <input type="hidden" name="oc_id" value="{{ $id }}">
            <input type="hidden" name="perusahaan_id" value="{{ $oc[0]->id_perusahaan_diverifikasi }}">
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%">No Referensi</td>
                        <td width="70%">
                            <input type="text" class="form-control col-md-4" autocomplete="off" disabled value="AUTO" />
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Tanggal Mulai Pelaksanaan</td>
                        <td width="70%">
                            <input type="text" class="form-control col-md-4 tanggal" data-toggle="datetimepicker" name="tgl_mulai" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Selesai Pelaksanaan</td>
                        <td>
                            <input type="text" class="form-control col-md-4 tanggal" data-toggle="datetimepicker" name="tgl_akhir" placeholder="DD/MM/YYYY" autocomplete="off" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Total Produk</td>
                        <td>
                            {{$oc[0]->objek_order}}
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah Produk yang akan Diverifikasi</td>
                        <td>
                            <input type="number" class="form-control col-md-4" name="jml_produk"  required min="1" max="{{$oc[0]->objek_order}}" />
                        </td>
                    </tr>
                    <tr>
                        <td>PM</td>
                        <td> 
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" class="form-control" disabled value="{{Auth::user()->name}}" />
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Verifikator 1</td>
                        <td> 
                            <div class="row">
                                <div class="col-md-10">
                                    <select class="form-control select2bs4" required name="verifikator[]">
                                        <option value="">-PILIH-</option>
                                        @foreach($verifikator as $key)
                                        <option value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" name="add" onclick="addVerifikator()">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tbody id="verifikator"></tbody>
                    <tr>
                        <td>ETC</td>
                        <td> 
                            <div class="row">
                                <div class="col-md-10">
                                    <select class="form-control select2bs4" name="etc" required>
                                        <option value="">-PILIH-</option>
                                        @foreach($etc as $key)
                                        <option value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <!-- <button type="button" class="btn btn-success" name="add" onclick="addEtc()">
                                        <i class="fas fa-plus-circle"></i>
                                    </button> -->
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tbody id="etc"></tbody>
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
    let count = 1
    function addVerifikator(){
        if(count < 5){
            count += 1;
            $("#verifikator").append(''
                +'<tr id="verifikator'+count+'">'
                    +'<td>Verifikator '+count+'</td>'
                    +'<td> '
                        +'<div class="row">'
                            +'<div class="col-md-10">'
                                +'<select class="form-control select2bs4" required name="verifikator[]">'
                                    +'<option value="">-PILIH-</option>`'
                                    +'@foreach($verifikator as $key)'
                                    +'<option value="{{$key->id}}">{{$key->name}}</option>'
                                    +'@endforeach'
                                +'.`</select>'
                            +'</div>'
                            +'<div class="col-md-2">'
                                +'<button type="button" class="btn btn-danger" name="add" value="'+count+'" onclick="removeVerifikator(this)">'
                                    +'<i class="fas fa-trash"></i>'
                                +'</button>'
                            +'</div>'
                        +'</div>'
                    +'</td>'
                +'</tr>')
        }
    }

    function addEtc(){
        count += 1;
        $("#etc").append(''
            +'<tr id="etc'+count+'">'
                +'<td>ETC</td>'
                +'<td> '
                    +'<div class="row">'
                        +'<div class="col-md-10">'
                            +'<select class="form-control select2bs4" required name="etc[]">'
                                +'<option value="">-PILIH-</option>'
                                +'@foreach($etc as $key)'
                                +'<option value="{{$key->id}}">{{$key->name}}</option>'
                                +'@endforeach'
                            +'</select>'
                        +'</div>'
                        +'<div class="col-md-2">'
                            +'<button type="button" class="btn btn-danger" name="add" value="'+count+'" onclick="removeEtc(this)">'
                                +'<i class="fas fa-trash"></i>'
                            +'</button>'
                        +'</div>'
                    +'</div>'
                +'</td>'
            +'</tr>')
    }

    function removeVerifikator(data){
        $(`tr[id="verifikator${data.value}"]`).remove()
    }

    function removeEtc(data){
        $(`tr[id="verifikator${data.value}"]`).remove()
    }

    $(function () {
        $("#table1").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "ajax": {
                "url": "{{ url('penugasan/getSurtug')}}"+'/<?=$id?>',
                "dataSrc": ""
            },
            "columns": [
                { "data": "no" },
                { "data": "no_ref" },
                { "data": "tgl_mulai" },
                { "data": "tgl_akhir" },
                { "data": "pm" },
                { "data": "verif" },
                { "data": "etc" },
                { "data": "jml_produk" },
                { "data": "action" }
            ]
        })
        .buttons()
        .container()
        .appendTo('#table1_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush