@extends('layouts.app')

@section('title','Verifikasi')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('verifikasi')}}">Verifikasi</a></li>
<li class="breadcrumb-item active">Pelaksanaan</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-play"></i>&nbsp; Mulai Pelaksanaan Verifikasi</h3>
            </div>
            <div class="card-body" id="table1_wrapper">
                <div class="row">
                    <div class="col-md-3">
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
                    <div class="col-md-2">
                        <small class="text-muted">Peraturan Menteri</small>
                        <h5>
                            {{ $penugasan[0]->nama_permen }}
                        </h5>
                        <small class="text-muted">Jumlah Produk</small>
                        <h5><i class="text-default">{{ $penugasan[0]->jml_produk }}</i></h5>
                        <small class="text-muted">Jumlah Produk yang Telah Diverifikasi</small>
                        <h5><i class="text-default">{{ (int)$jumlahVerify }}</i></h5>
                        <small class="text-muted">Laporan</small>
                        <h5>
                            <a href="{{ url('verifikasi/viewLaporan/'.$penugasan[0]->id) }}" class="btn btn-success"><i class="fa fa-file"></i> View Laporan</a>
                        </h5>
                    </div>
                    <div class="col-md-2">
                        <form action="{{url('verifikasi/simpan_self')}}" method="POST">
                            @csrf
                            <input type="hidden" name="penugasan_id" value="{{$penugasan[0]->id}}">
                            <small class="text-muted">Self Assessment (%)</small>
                            <h5>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        @if($penugasan[0]->check_self == "on")
                                        <input type="checkbox" name="check_self" class="form-control" onclick="checkSelf(this.checked)" checked>
                                        @else
                                        <input type="checkbox" name="check_self" class="form-control" onclick="checkSelf(this.checked)">
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        @if($penugasan[0]->check_self == "on")
                                        <div class="input-group">
                                            <input type="number" name="nilai_self" class="form-control" id="nilai_self" placeholder="persen (%)" value="{{@$penugasan[0]->nilai_self}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        @else
                                        <div class="input-group">
                                            <input type="number" name="nilai_self" class="form-control" id="nilai_self" placeholder="persen (%)" disabled="true">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </h5>
                            <small class="text-muted">Jumlah Vendor</small>
                            <h5>
                                @if($penugasan[0]->jml_vendor == "")
                                <input type="number" min="0" name="jml_vendor" class="form-control" required value="0" />
                                @else
                                <input type="number" min="0" name="jml_vendor" class="form-control" required value="{{$penugasan[0]->jml_vendor}}" />
                                @endif
                            </h5>
                            <small class="text-muted">Jumlah Bahan Baku</small>
                            <h5>
                                @if($penugasan[0]->jml_vendor == "")
                                <input type="number" min="0" name="jml_bahan_baku" class="form-control" value="0" required />
                                @else
                                <input type="number" min="0" name="jml_bahan_baku" class="form-control" value="{{$penugasan[0]->jml_bahan_baku}}" required />
                                @endif
                            </h5>
                            <small class="text-muted">Simpan</small>
                            <h5>
                                <button class="btn btn-sm btn-primary">Simpan</button>
                            </h5>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <table class="table table-bordered table-sm">
                            <tr>
                                @if($penugasan[0]->permen_id == 2 || $penugasan[0]->permen_id == 5 || $penugasan[0]->permen_id == 6)
                                <th colspan="2">Perusahaan Pemegang Merk</th>
                                @else
                                <th colspan="2">Perusahaan yang Diverifikasi</th>
                                @endif
                            </tr>
                            <tr>
                                <td>{!! $penugasan[0]->nama !!}</td>
                                <td>
                                    {!! $penugasan[0]->alamat !!}
                                    <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-alamat" data-perusahaan_id="{{ $penugasan[0]->perusahaan_id }}" data-perusahaan_nama="{!! $penugasan[0]->nama !!}" data-tipe_alamat="alamat_id" data-alamat_id="{!! $penugasan[0]->alamat_id !!}">
                                        Ganti Alamat Pabrik
                                    </a>
                                </td>
                            </tr>
                            @if($penugasan[0]->permen_id == 2 || $penugasan[0]->permen_id == 5 || $penugasan[0]->permen_id == 6)
                            <tr>
                                <th colspan="2">Perusahaan Pabrikan Lokal</th>
                            </tr>
                            <tr>
                                <td>{!! $penugasan[0]->nama_lokal !!} <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-perusahaan" data-field="perusahaan_lokal_id">Ganti Perusahaan</a></td>
                                <td>{!! $penugasan[0]->alamat_lokal !!}
                                    <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-alamat" data-perusahaan_id="{{ $penugasan[0]->perusahaan_lokal_id }}" data-perusahaan_nama="{!! $penugasan[0]->nama_lokal !!}" data-tipe_alamat="alamat_lokal_id" data-alamat_id="{!! $penugasan[0]->alamat_lokal_id !!}">
                                        Ganti Alamat Pabrik
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">Perusahaan Pengembang</th>
                            </tr>
                            <tr>
                                <td>{!! $penugasan[0]->nama_pengembang !!} <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-perusahaan" data-field="perusahaan_pengembang_id">Ganti Perusahaan</a></td>
                                <td>
                                    {!! $penugasan[0]->alamat_pengembang !!}
                                    <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-alamat" data-perusahaan_id="{{ $penugasan[0]->perusahaan_pengembang_id }}" data-perusahaan_nama="{!! $penugasan[0]->nama_pengembang !!}" data-tipe_alamat="alamat_pengembang_id" data-alamat_id="{!! $penugasan[0]->alamat_pengembang_id !!}">
                                        Ganti Alamat Pabrik
                                    </a>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <br>

                <table id="table1" class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-center table-primary">
                        @if($penugasan[0]->permen_id == 3)
                        <tr>
                            <th>No</th>
                            <th>Kelompok Barang/Jasa</th>
                            <th>Bidang Usaha</th>
                            <th>Kategori Produk</th>
                            <th>Bentuk Sediaan</th>
                            <th>Nama Obat</th>
                            <th>File</th>
                            <th>Capaian TKDN (%)</th>
                            <th>Status</th>
                            <th style="width: 9%;"></th>
                        </tr>
                        @else
                        <tr>
                            <th>No</th>
                            <th>Kelompok Barang/Jasa</th>
                            <th>Bidang Usaha</th>
                            <th>Jenis Produk</th>
                            <th>Tipe</th>
                            <th>Merk</th>
                            <th>File</th>
                            <th>Capaian TKDN (%)</th>
                            <th>Status</th>
                            <th style="width: 9%;"></th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>


<!-- modul edit perusahaan -->
<div class="modal fade" id="modal-perusahaan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Perusahaan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('verifikasi/simpan_perusahaan')}}" method="post">
                @csrf
                <input type="hidden" id="penugas_id" name="penugas_id" value="{{$id}}">
                <input type="hidden" id="tipe_perusahaan" name="tipe_perusahaan" value="">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3">Pilih Perusahaan</label>
                        <div class="col-md-9">
                            <select class="form-control select2bs4" name="perusahaan_id" required>
                                <option value="">-PILIH-</option>
                                @foreach($perusahaan as $key)
                                <option value="{{$key->id}}">{{$key->nama}}</option>
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

<!-- modal alamat -->
<div class="modal fade" id="modal-alamat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">PILIH ALAMAT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('verifikasi/simpan_alamat')}}" method="post">
                @csrf
                <input type="hidden" id="penugas_id" name="penugas_id" value="{{$id}}">
                <input type="hidden" id="tipe_alamat" name="tipe_alamat" value="">
                <input type="hidden" id="perusahaan_id_alamat" name="perusahaan_id_alamat" value="">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3">Nama Perusahaan</label>
                        <div class="col-md-9">
                            <input type="text" disabled id="perusahaan_nama" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Pilih Alamat</label>
                        <div class="col-md-9">
                            <select class="form-control select2bs4" id="select_alamat" name="alamat" required>
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
    $(function() {
        var table1 = $("#table1").DataTable({
                "responsive": false,
                "scrollX": true,
                "lengthChange": false,
                "autoWidth": false,
                "destroy": true,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "ajax": {
                    "url": "{{ url('verifikasi/getDataVerProduk') }}",
                    "data": {
                        'id': '{{$penugasan[0]->id}}'
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
                        "data": "merk"
                    },
                    {
                        "data": "file"
                    },
                    {
                        "data": "capaian_tkdn"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "action"
                    }
                ]
            })
            .buttons()
            .container()
            .appendTo('#table1_wrapper .col-md-6:eq(0)');


        $(document).on("click", ".btn-modal-upload", function() {
            var produk_id = $(this).data('produk_id');
            $("#modal-upload #ver_produk_id").val(produk_id);
            tableUpload(produk_id)
        });

        $('#modal-editproduk').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var produk_id = button.data('produk_id')
            var modal = $(this)
            $.ajax({
                url: "{{url('verifikasi/getEditProduk')}}",
                data: {
                    "produk_id": produk_id
                }
            }).done(function(m) {
                var obj = JSON.parse(m);
                modal.find('#edit_ver_produk_id').val(obj.id)
                modal.find('#kelompok_id').val(obj.kelompok_id)
                modal.find('#bidang_usaha').val(obj.bidang_usaha)
                modal.find('#jenis_produk').val(obj.jenis_produk)
                modal.find('#tipe').val(obj.tipe)
                modal.find('#spesifikasi').val(obj.spesifikasi)
                modal.find('#merk').val(obj.merk)
                modal.find('#standar_produk').val(obj.standar_produk)
                modal.find('#sertifikat_produk').val(obj.sertifikat_produk)
                modal.find('#kapasitas_izin').val(obj.kapasitas_izin)
                modal.find('#kapasitas_vki').val(obj.kapasitas_vki)
            })
        })

        $('#modal-perusahaan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            var field = button.data('field')
            $('#tipe_perusahaan').val(field);
        })

        $('#modal-alamat').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            var perusahaan_id = button.data('perusahaan_id')
            var perusahaan_nama = button.data('perusahaan_nama')
            var alamat_id = button.data('alamat_id')
            var tipe_alamat = button.data('tipe_alamat')
            $('#perusahaan_nama').val(perusahaan_nama);
            $('#perusahaan_id_alamat').val(perusahaan_id);
            // $('#alamat_id').val(alamat_id);
            $('#tipe_alamat').val(tipe_alamat);
            $.ajax({
                url: "{{url('verifikasi/getAlamat')}}",
                data: {
                    "perusahaan_id": perusahaan_id,
                    "alamat_id": alamat_id,
                    "tipe_alamat": tipe_alamat,
                }
            }).done(function(m) {
                var obj = JSON.parse(m);
                $('#select_alamat').empty();
                for (var i = 0; i < obj.length; i++) {
                    $('#select_alamat').append('<option value="' + obj[i]['id'] + '">' + obj[i]['alamat'] + '</option>');
                }
            })
        })
    });


    function checkSelf(value) {
        if (value) {
            $('#nilai_self').attr('disabled', false);
        } else {
            $('#nilai_self').attr('disabled', true);
        }
    }
</script>
@endpush