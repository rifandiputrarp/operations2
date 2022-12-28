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
                    <h3 class="card-title">Alamat Master Perusahaan</h3>
                </div>
                <div class="card-body">

                    <div class="bs-stepper">
                        <form action="{{url('/master-perusahaan/update_alamat/'.$id)}}" method="post" id="form">
                            {{csrf_field()}}

                            <input type="hidden" name="kode" value="{{@$data}}">

                            <div class="form-group" style="margin-bottom:30px">
                                <label>Badan Perusahaan*</label>
                                <input class="form-control col-md-2" list="list_badan" name="badan" id="badan" value="{{@$data_perusahaan[0]->badan}}" autocomplete="off" disabled>
                            </div>

                            <div class="form-group" style="margin-bottom:30px">
                                <label>Nama Perusahaan</label>
                                <input type="text" class="form-control" placeholder="Nama Perusahaan" name="nama" value="{{@$data_perusahaan[0]->nama}}" required disabled>
                            </div>


                            <a  class="btn btn-success"  onclick="add()"><i class="fa fa-plus"></i> Tambah Data</a>
                            <br>
                            <br>
                            <table id="content" style="width: 100%">
                                <?php $counter = 1;?>
                                @foreach($data as $data_alamat)

                            <tr><td>
                            <div class="card card-primary" >
                                <div class="card-header">
                                    <h3 class="card-title">Data Alamat <?php echo $counter;?></h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                            <button type="button" class="btn btn-tool" onclick="delete_row(this)"><i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Jenis Kantor</label>
                                            <select class="form-control col_jenis_kantor"  name="jenis_kantor[]" data-placeholder="Silahkan Pilih..." required>
                                                <option value="">Silahkan pilih</option>
                                                <option <?php if($data_alamat->jenis_kantor==1){echo "selected";}?> value="1" selected>Pusat</option>
                                                <option <?php if($data_alamat->jenis_kantor==2){echo "selected";}?> value="2" >Pabrik</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Alamat Kantor</label>
                                        <textarea class="form-control" placeholder="Alamat lengkap" name="alamat[]">{{$data_alamat->alamat}}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Provinsi</label>
                                                <select id="provinsi<?php echo $counter;?>" class="form-control js-example-basic-single" name="kode_provinsi[]" onchange="selectProvinsi3('<?php echo $counter;?>')">
                                                    <option value="">Please Select</option>
                                                    @foreach($provinsi as $g)
                                                        @if($g->kode_provinsi == $data_alamat->kode_provinsi)
                                                            <option value="{{$g->kode_provinsi}}" selected>{{$g->provinsi}}</option>
                                                        @else
                                                            <option value="{{$g->kode_provinsi}}">{{$g->provinsi}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Kabupaten / Kota</label>
                                                <select id="kab<?php echo $counter;?>" class="form-control" name="kode_kabupaten[]" data-placeholder="Silahkan Pilih..." onchange="selectKab('<?php echo $counter;?>')">
                                                    <option value="">Silahkan pilih provinsi terlebih dahulu...</option>
                                                    <option value="{{$data_alamat->kode_kabupaten}}" selected>{{$data_alamat->kabupaten}}</option>
{{--                                                    <option value="">Silahkan pilih</option>--}}
                                                    {{-- @foreach($kabupaten as $key)
                                                        @if($key->kode_kota_kab == $data_alamat->kode_kabupaten)
                                                            <option value="{{$key->kode_kota_kab}}" selected>{{$key->kota}}</option>
                                                        @else
                                                            <option value="{{$key->kode_kota_kab}}">{{$key->kota}}</option>
                                                        @endif
                                                    @endforeach--}}
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Kecamatan</label>
                                                <select id="kec<?php echo $counter;?>" class="form-control" name="kode_kec[]" data-placeholder="Silahkan Pilih..." onchange="selectKec('<?php echo $counter;?>')">
                                                    <option value="">Silahkan pilih kota/kabupaten terlebih dahulu...</option>
                                                    <option value="{{$data_alamat->kode_kecamatan}}" selected>{{$data_alamat->kecamatan}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Kelurahan</label>
                                                <select id="kel<?php echo $counter;?>" class="form-control" name="kode_kel[]" data-placeholder="Silahkan Pilih...">
                                                    <option value="">Silahkan pilih kecamatan terlebih dahulu...</option>
                                                    <option value="{{$data_alamat->kode_kelurahan}}" selected>{{$data_alamat->kelurahan}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 20px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input class="form-control" placeholder="Alamat Email" name="email[]" value="{{$data_alamat->email}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Kode Pos</label>
                                                <input class="form-control" placeholder="Kode Pos " name="kode_pos[]" value="{{$data_alamat->kode_pos}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 20px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Telepon</label>
                                                <input class="form-control" placeholder="Telepon " name="telepon[]" value="{{$data_alamat->telepon}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Fax</label>
                                                <input class="form-control" placeholder="Fax " name="fax[]" value="{{$data_alamat->fax}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </td></tr>

    <?php $counter = $counter+1;?>
                                @endforeach
                            </table>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                    </div>
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

@push('js')
    <script>
        var count=<?php echo $counter;?>;
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        $( "#form" ).submit(function( event ) {
            var jenis_kantor = $('.col_jenis_kantor').serializeArray();
            var found = 0;
            $.each(jenis_kantor, function(i, field){
                if(field.value==1){
                    found++;
                }
            });
            if(found<2){
                $("#form").submit();
            }else{
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Terjadi Kesalahan',
                    text: "Terdapat lebih dari satu Kantor Pusat",
                })
            }
        });

        function add() {
            $("#content").append(
                '<tr><td>'+
                '<div class="card card-primary">' +
                '<div class="card-header">' +
                '<h3 class="card-title">Data Alamat '+count+'</h3> ' +
                '<div class="card-tools"> ' +
                ' <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>' +
                ' <button type="button" class="btn btn-tool" onclick="delete_row(this)"><i class="fas fa-trash"></i> ' +
                '</button> ' +
                '</div> ' +
                '</div> ' +
                '<div class="card-body"> ' +
                '<div class="col-md-6"> ' +
                '<div class="form-group"> ' +
                '   <label for="exampleInputPassword1">Jenis Kantor</label> ' +
                '       <select class="form-control col_jenis_kantor" name="jenis_kantor[]" data-placeholder="Silahkan Pilih..." required>' +
                '           <option value="">Silahkan pilih</option>' +
                '           <option value="1" >Pusat</option> ' +
                '           <option value="2" >Pabrik</option> ' +
                '       </select> ' +
                '   </div> ' +
                '</div>' +
                '<div class="form-group"> ' +
                '   <label for="exampleInputPassword1">Alamat Kantor</label> ' +
                '   <textarea class="form-control" placeholder="Alamat lengkap" name="alamat[]"></textarea> '+
                '</div>' +
                '<div class="row">' +
                '                    <div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="exampleInputPassword1">Provinsi</label>' +
                '                            <select id="provinsi'+count+'" class="form-control js-example-basic-single" name="kode_provinsi[]" onchange="selectProvinsi3(\''+count+'\')">' +
                '                                <option value="">Please Select</option>' +
                '                                @foreach($provinsi as $g)'+
                '                                       <option value="{{$g->kode_provinsi}}">{{$g->provinsi}}</option>'+
                '                               @endforeach'+
                '                           </select>'+
                '                       </div>'+
                '                    </div>' +
                '                    <div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="exampleInputPassword1">Kabupaten / Kota</label>' +
                '                            <select id="kab'+count+'" class="form-control" name="kode_kabupaten[]" data-placeholder="Silahkan Pilih..." onchange="selectKab(\''+count+'\')">' +
                '                                 <option value="">Silahkan pilih provinsi terlebih dahulu...</option>'+
                '                           </select>' +
                '                        </div>' +
                '                    </div>' +
                '                </div> ' +
                '                <div class="row">' +
                '                    <div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="exampleInputPassword1">Kecamatan</label>' +
                '                            <select id="kec'+count+'" class="form-control" name="kode_kec[]" data-placeholder="Silahkan Pilih..." onchange="selectKec(\''+count+'\')">' +
                '                                <option value="">Silahkan pilih kota/kabupaten terlebih dahulu...</option>' +
                '                            </select>' +
                '                         </div>' +
                '                    </div>' +
                '                    <div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="exampleInputPassword1">Kelurahan</label>' +
                '                            <select id="kel'+count+'" class="form-control" name="kode_kel[]" data-placeholder="Silahkan Pilih...">' +
                '                                <option value="">Silahkan pilih kecamatan terlebih dahulu...</option>' +
                '                           </select>' +
                '                        </div>' +
                '                    </div>' +
                '                </div>' +
                '                <div class="row" style="margin-bottom: 20px">' +
                '                    <div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="exampleInputPassword1">Email</label>' +
                '                            <input class="form-control" placeholder="Alamat Email" name="email[]" value="">'+
                '                       </div>' +
                '                    </div>' +
                '                    <div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="exampleInputPassword1">Kode Pos</label>' +
                '                            <input class="form-control" placeholder="Kode Pos" name="kode_pos[]" value="">'+
                '                    </div>' +
                '                    </div>' +
                '                </div>' +
                '                <div class="row" style="margin-bottom: 20px">' +
                '                    <div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="exampleInputPassword1">Telepon</label>' +
                '                            <input class="form-control" placeholder="Telepon" name="telepon[]" value="">'+
                '                   </div>' +
                '                    </div>' +
                '                    <div class="col-md-6"> ' +
                '                     <div class="form-group">' +
                '                            <label>Fax</label>' +
                '                            <input class="form-control" placeholder="Fax" name="fax[]" value="">'+
                '                     </div>' +
                '                    </div>' +
                '               </div>' +
                '            </div>' +
                '        </div>' +
                '        </td></tr>');
            $('.js-example-basic-single').select2();
            count++;
        }

        function delete_row(e)
        {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin hapus item ini?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode.parentNode.parentNode);
                }
            })
        }

        function selectProvinsi() {
            if ($('#provinsi').val() != "") {
                $('#kab').empty();
                $('#kab').select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kab")}}' + '/' + $('#provinsi').val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.kota,
                                        id: e.kode_kota_kab
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectProvinsi3(c) {
            var idKab = '#kab'+c;
            var idProv = '#provinsi'+c;

            if ($(idProv).val() != "") {
                $(idKab).empty();
                $(idKab).select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kab")}}' + '/' + $(idProv).val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.kota,
                                        id: e.kode_kota_kab
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectKab() {
            if ($('#kab').val() != "") {
                $('#kec').empty();
                $('#kec').select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kec")}}' + '/' + $('#kab').val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.kecamatan,
                                        id: e.kode_kec
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectKab(c) {
            var idKab = '#kab'+c;
            var idKec = '#kec'+c;

            if ($(idKab).val() != "") {
                $(idKec).empty();
                $(idKec).select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kec")}}' + '/' + $(idKab).val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.kecamatan,
                                        id: e.kode_kec
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectKec() {
            if ($('#kec').val() != "") {
                $('#kel').empty();
                $('#kel').select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kel")}}' + '/' + $('#kec').val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.desa_kelurahan,
                                        id: e.kode_desa
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectKec(c) {
            var idKec = '#kec'+c;
            var idKel = '#kel'+c;

            if ($(idKec).val() != "") {
                $(idKel).empty();
                $(idKel).select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kel")}}' + '/' + $(idKec).val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.desa_kelurahan,
                                        id: e.kode_desa
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectProvinsi2() {
            if ($('#provinsi2').val() != "") {
                $('#kab2').empty();
                $('#kab2').select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kab")}}' + '/' + $('#provinsi2').val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.kota,
                                        id: e.kode_kota_kab
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectKab2() {
            if ($('#kab2').val() != "") {
                $('#kec2').empty();
                $('#kec2').select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kec")}}' + '/' + $('#kab2').val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.kecamatan,
                                        id: e.kode_kec
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

        function selectKec2() {
            if ($('#kec2').val() != "") {
                $('#kel2').empty();
                $('#kel2').select2({
                    ajax: {
                        url: '{{url("master-perusahaan/kel")}}' + '/' + $('#kec2').val(),
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data.map((e) => {
                                    return {
                                        text: e.desa_kelurahan,
                                        id: e.kode_desa
                                    };
                                })
                            };
                        }
                    }
                });
            }
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endpush
