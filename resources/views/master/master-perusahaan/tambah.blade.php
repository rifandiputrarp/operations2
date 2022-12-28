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
                <h3 class="card-title">Tambah Master Perusahaan</h3>
            </div>
            <div class="card-body">

            <div class="bs-stepper">
                <form action="{{url('master-perusahaan/post')}}" method="post">
                    {{csrf_field()}}

                        <input type="hidden" name="kode" value="{{$data}}">

                        <div class="form-group" style="margin-bottom:30px">
                            <label>Badan Perusahaan*</label>
                            <input class="form-control col-md-2" list="list_badan" name="badan" id="badan" autocomplete="off">
                            <datalist id="list_badan">
                                @foreach($badan as $key)
                                <option value="{{$key->nama_badan}}">
                                @endforeach
                            </datalist>
                        </div>

                        <div class="form-group" style="margin-bottom:30px">
                            <label>Nama Perusahaan*</label>
                            <input type="text" class="form-control" placeholder="Nama Perusahaan" name="nama" required>
                        </div>
                        <br>
                       {{-- <hr data-content="Alamat Kantor Pusat" class="hr-text">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Kantor Pusat</label>
                            <textarea class="form-control" placeholder="Alamat lengkap" name="alamat_pusat"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Provinsi</label>
                                    <select id="provinsi" class="form-control js-example-basic-single" name="kode_provinsi" onchange="selectProvinsi()" >
                                        <option value="">Please Select</option>
                                        @foreach($provinsi as $g)
                                            <option value="{{$g->kode_provinsi}}">{{$g->provinsi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kabupaten / Kota</label>
                                    <select id="kab" class="form-control" name="kode_kabupaten" data-placeholder="Silahkan Pilih..." onchange="selectKab()" >
                                        <option value="">Silahkan pilih provinsi terlebih dahulu...</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                               <div class="form-group">
                                    <label for="exampleInputPassword1">Kecamatan</label>
                                    <select id="kec" class="form-control" name="kode_kec" data-placeholder="Silahkan Pilih..." onchange="selectKec()" >
                                            <option value="">Silahkan pilih kota/kabupaten terlebih dahulu...</option>
                                        </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kelurahan</label>
                                    <select id="kel" class="form-control" name="kode_kel" data-placeholder="Silahkan Pilih..." >
                                            <option value="">Silahkan pilih kecamatan terlebih dahulu...</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email</label>
                                    <input class="form-control" placeholder="Alamat Email" name="email_pusat">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kode Pos</label>
                                    <input class="form-control" placeholder="Kode Pos Pusat" name="kode_pos">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Telepon</label>
                                    <input class="form-control" placeholder="Telepon Pusat" name="telepon">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input class="form-control" placeholder="Fax Pusat" name="fax">
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr data-content="Alamat Pabrik" class="hr-text">

                        <div class="form-group">
                            <label> Pabrik</label>
                            <textarea class="form-control" placeholder="Alamat lengkap" name="alamat_pabrik"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Provinsi</label>
                                    <select id="provinsi2" class="form-control js-example-basic-single" name="kode_provinsi2" onchange="selectProvinsi2()" >
                                        <option value="">Please Select</option>
                                        @foreach($provinsi as $g)
                                            <option value="{{$g->kode_provinsi}}">{{$g->provinsi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kabupaten / Kota</label>
                                    <select id="kab2" class="form-control" name="kode_kabupaten2" data-placeholder="Silahkan Pilih..." onchange="selectKab2()" >
                                        <option value="">Silahkan pilih provinsi terlebih dahulu...</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                               <div class="form-group">
                                    <label for="exampleInputPassword1">Kecamatan</label>
                                    <select id="kec2" class="form-control" name="kode_kec2" data-placeholder="Silahkan Pilih..." onchange="selectKec2()" >
                                            <option value="">Silahkan pilih kota/kabupaten terlebih dahulu...</option>
                                        </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kelurahan</label>
                                    <select id="kel2" class="form-control provinsi" name="kode_kel2" data-placeholder="Silahkan Pilih..." >
                                            <option value="">Silahkan pilih kecamatan terlebih dahulu...</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email</label>
                                    <input class="form-control" placeholder="Alamat Email" name="email_pabrik">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kode Pos</label>
                                    <input class="form-control" placeholder="Kode Post Pabrik" name="kode_pos2">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Telepon</label>
                                    <input class="form-control" placeholder="Telepon Pabrik" name="telepon2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input class="form-control" placeholder="Fax Pabrik" name="fax2">
                                </div>
                            </div>
                        </div>--}}

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Status Perusahaan</label>
                                    <input class="form-control" placeholder="Status Perusahaan" name="status">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Pejabat Penghubung</label>
                                    <input class="form-control" placeholder="Pejabat Penghubung" name="pejabat">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Jabatan</label>
                                    <input class="form-control" placeholder="Jabatan" name="jabatan">
                                </div>
                            </div>
                        </div>

                        <br>
                        <hr data-content="Aspek Legal" class="hr-text">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Akta Pendirian</label>
                                    <input type="text" class="form-control" placeholder="Akta Pendirian" name="akta">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Akta Pendirian</label>
                                    <input type="text" class="form-control tanggal" data-toggle="datetimepicker" placeholder="Tanggal Akta Pendirian (DD/MM/YYYY)" name="tanggal_akta">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ijin Usaha</label>
                                    <input type="text" class="form-control" placeholder="Ijin Usaha" name="ijin_usaha">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penerbit Ijin Usaha</label>
                                    <input type="text" class="form-control" placeholder="Penerbit Ijin Usaha" name="penerbit_ijin">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Notaris</label>
                                    <input type="text" class="form-control" placeholder="Notaris" name="notaris">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Terbit Ijin</label>
                                    <input type="text" class="form-control tanggal" data-toggle="datetimepicker" placeholder="Tanggal Terbit Ijin (DD/MM/YYYY)" name="tanggal_terbit_ijin" autocomplete="off" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" placeholder="NPWP" name="npwp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIB</label>
                                    <input type="text" class="form-control" placeholder="NIB" name="nib">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Saham Negeri (%)</label>
                                    <input type="text" class="form-control" placeholder="Saham dalam negeri" name="saham_negeri">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Saham Luar Negeri (%)</label>
                                    <input type="text" class="form-control" placeholder="Saham luar negeri" name="saham_luar_negeri">
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
    	height:40px !important;
	}

    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height:35px !important;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    function selectProvinsi() {
        if ($('#provinsi').val() != "") {
        $('#kab').select2({
            ajax: {
            url: '{{url('master-perusahaan/kab')}}'+'/'+$('#provinsi').val(),
            data: function (params) {
                var query = {
                search: params.term,
                }
                return query;
            },
            processResults: function (data) {
                return {
                results: data.map((e)=> {
                    return {text:e.kota, id:e.kode_kota_kab};
                })
                };
            }
            }
        });
        }
    }

    function selectKab() {
        if ($('#kab').val() != "") {
        $('#kec').select2({
            ajax: {
            url: '{{url('master-perusahaan/kec')}}'+'/'+$('#kab').val(),
            data: function (params) {
                var query = {
                search: params.term,
                }
                return query;
            },
            processResults: function (data) {
                return {
                results: data.map((e)=> {
                    return {text:e.kecamatan, id:e.kode_kec};
                })
                };
            }
            }
        });
        }
	}

    function selectKec() {
        if ($('#kec').val() != "") {
        $('#kel').select2({
            ajax: {
            url: '{{url('master-perusahaan/kel')}}'+'/'+$('#kec').val(),
            data: function (params) {
                var query = {
                search: params.term,
                }
                return query;
            },
            processResults: function (data) {
                return {
                results: data.map((e)=> {
                    return {text:e.desa_kelurahan, id:e.kode_desa};
                })
                };
            }
            }
        });
        }
	}

    function selectProvinsi2() {
        if ($('#provinsi2').val() != "") {
        $('#kab2').select2({
            ajax: {
            url: '{{url('master-perusahaan/kab')}}'+'/'+$('#provinsi2').val(),
            data: function (params) {
                var query = {
                search: params.term,
                }
                return query;
            },
            processResults: function (data) {
                return {
                results: data.map((e)=> {
                    return {text:e.kota, id:e.kode_kota_kab};
                })
                };
            }
            }
        });
        }
    }

    function selectKab2() {
        if ($('#kab2').val() != "") {
        $('#kec2').select2({
            ajax: {
            url: '{{url('master-perusahaan/kec')}}'+'/'+$('#kab2').val(),
            data: function (params) {
                var query = {
                search: params.term,
                }
                return query;
            },
            processResults: function (data) {
                return {
                results: data.map((e)=> {
                    return {text:e.kecamatan, id:e.kode_kec};
                })
                };
            }
            }
        });
        }
	}

    function selectKec2() {
        if ($('#kec2').val() != "") {
        $('#kel2').select2({
            ajax: {
            url: '{{url('master-perusahaan/kel')}}'+'/'+$('#kec2').val(),
            data: function (params) {
                var query = {
                search: params.term,
                }
                return query;
            },
            processResults: function (data) {
                return {
                results: data.map((e)=> {
                    return {text:e.desa_kelurahan, id:e.kode_desa};
                })
                };
            }
            }
        });
        }
	}
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('adminlte/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<script>
       document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script>
@endpush
