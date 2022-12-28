@extends('layouts.app')

@section('title','Konfirmasi Order')

@section('breadcrumb')
<li class="breadcrumb-item">Konfirmasi Order</li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Konfirmasi Order</h3>
            </div>
            <form action="{{url('konfirmasi-order/update/'.$id)}}" method="post">
                <div class="card-body p-0">
                    {{csrf_field()}}

                    <table class="table table-borderless">
                        <tr>
                            <th style="width:25%">Status Pembayaran</th>
                            <td colspan="5">
                                <input type="radio" required name="berbayar" value="0" onclick="handleBerbayar(0)" <?php if ($dataPerusahaan->berbayar === 0) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>> Tidak Berbayar
                                &nbsp;
                                <input type="radio" required name="berbayar" value="1" onclick="handleBerbayar(1)" <?php if ($dataPerusahaan->berbayar === 1) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>> Berbayar
                            </td>
                        </tr>
                        <tr>
                            <th>Perusahaan yang Diverifikasi</th>
                            <td colspan="3">
                                <select class="form-control js-example-basic-single" name="id_perusahaan_diverifikasi" style="width:100%" onchange="autofillverif(this.value)" required>
                                    <option value="">Please Select</option>
                                    @foreach($data as $g)
                                    <option value="{{$g->id}}" <?php if ($g->id == $dataPerusahaan->id_perusahaan_diverifikasi) {
                                                                    echo 'selected';
                                                                } ?>>{{$g->nama}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat Perusahaan yang diverifikasi</th>
                            <td colspan="5">
                                <textarea class="form-control" id="alamat_diverifikasi" id="alamat_diverifikasi" readonly>{{$alamat_verifikasi[0]->alamat_pusat}}</textarea>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Perusahaan yang Ditagihkan</th>
                            <td colspan="2">
                                <select class="form-control js-example-basic-single" name="id_perusahaan_ditagihkan" id="select_berbayar" style="width:100%" onchange="autofilltagihan(this.value)" required>
                                    <option value="">Please Select</option>
                                    @foreach($data as $g)
                                    <option value="{{$g->id}}" <?php if ($g->id == $dataPerusahaan->id_perusahaan_ditagihkan) {
                                                                    echo 'selected';
                                                                } ?>>{{$g->nama}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Alamat yang Ditagihkan</th>
                            <td colspan="5">
                                <textarea class="form-control" id="alamat_ditagihkan" id="alamat_ditagihkan" readonly>{{@$alamat_tagihan[0]->alamat_pusat}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Nomor</th>
                            <td colspan="2">
                                <input class="form-control" style="width:40%" name="nomor" value="{{$dataPerusahaan->nomor}}">
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td colspan="5">
                                <input class="form-control" type="date" name="tanggal" style="width:40%" value="{{$dataPerusahaan->tanggal}}">
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Jenis Jasa</th>
                            <td colspan="3">
                                <input class="form-control" name="jenis_jasa" value="Verifikasi Tingkat Komponen Dalam Negeri (TKDN)" readonly style="width:50%">
                            </td>
                        </tr>
                        <th>Objek Order</th>
                        <td colspan="1">
                            <input type="number" class="form-control" name="objek_order" value="{{$dataPerusahaan->objek_order}}" style="width:40%" onchange="genTable(this.value)" readonly>
                        </td>
                        <tr class="berbayar">
                            <th>Waktu Pelaksanaan</th>
                            <td colspan="1">
                                <div class="input-group mb-3" style="width:30%">
                                    <input type="number" class="form-control" name="waktu_pelaksanaan" value="{{$dataPerusahaan->waktu_pelaksanaan}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Hari Kerja</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Keterangan</th>
                            <td colspan="5">
                                <textarea name="keterangan" id="editor">{!! $dataPerusahaan->keterangan !!}</textarea>
                            </td>
                        <tr class="berbayar">
                            <th>Total Biaya</th>
                            <td colspan="1">
                                <div class="input-group" style="width:40%">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                    <input type="text" class="form-control uang" name="total_biaya" value="{{$dataPerusahaan->total_biaya}}">
                                </div>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>
                                Pembayaran
                            </th>
                            <td colspan="5">
                                <table class="table table-bordered text-center">
                                    <tr>
                                        <th>Termin</th>
                                        <th>Persentase</th>
                                        <th>Output</th>
                                    </tr>
                                    @foreach($pembayaran as $idx => $data)
                                    <tr id="pembayaran{{$idx}}">
                                        <td>
                                            <input type="number" class="form-control" name="termin[]" value="{{$data->termin}}">
                                        </td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="persentase[]" value="{{$data->persentase}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <select class="form-control" style="float:left" name="output[]">
                                                        <option value="">Silahkan Pilih</option>
                                                        <option value="Opening Meeting" <?php if ('Opening Meeting' == $data->output) {
                                                                                            echo 'selected';
                                                                                        } ?>>Opening Meeting</option>
                                                        <option value="Opening Meeting/Kunjungan Lapangan" <?php if ('Opening Meeting/Kunjungan Lapangan' == $data->output) {
                                                                                                                echo 'selected';
                                                                                                            } ?>>Opening Meeting/Kunjungan Lapangan</option>
                                                        <option value="Sertifikat Terbit" <?php if ('Sertifikat Terbit' == $data->output) {
                                                                                                echo 'selected';
                                                                                            } ?>>Sertifikat Terbit</option>
                                                    </select>
                                                </div>
                                                @if($idx > 0)
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger" name="add" value="{{$idx}}" onclick="remove(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                @else
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-success" name="add" onclick="dinamis()">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tbody id="add_pembayaran"></tbody>
                                </table>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Seluruh Biaya dibebankan kepada</th>
                            <td colspan="5"> <input class="form-control" name="dibebankan_kepada" id="beban_biaya" value="{{$dataPerusahaan->dibebankan_kepada}}"></td>
                        </tr>
                        <tr class="berbayar">
                            <th>Referensi</th>
                            <td colspan="5">
                                <textarea name="referensi" id="editor2">{!! $dataPerusahaan->keterangan !!}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Produk yang di verifikasi
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-8">
                                        <label> Tambah Produk</label>
                                        <input type="number" id="add_produk" class="form-control">
                                    </div>
                                    <div class="col-md-2" style="display:flex">
                                        <button type="button" class="btn btn-success" name="add" onclick="genTable()" style="align-self:end">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </th>
                            <td colspan="5">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>Nama/Jenis Produk</th>
                                            <th>Tipe Produk</th>
                                            <th>Spesifikasi Produk</th>
                                        </tr>
                                    </thead>

                                    <tbody id="produk">
                                        @foreach($produk as $idx => $data)
                                        <tr id="produk{{$idx}}">
                                            <!-- <td>{{$idx+1}}<input type="hidden" class="lastId" value="{{$idx+1}}"></td> -->
                                            <td><input type="text" class="form-control" name="nama_produk[]" value="{{$data->nama_produk}}"></td>
                                            <td><input type="text" class="form-control" name="tipe_produk[]" value="{{$data->tipe_produk}}"></td>
                                            <td><input type="text" class="form-control" name="spesifikasi_produk[]" value="{{$data->spesifikasi_produk}}"></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" name="add" value="{{$idx}}" onclick="removeTable(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/bs-stepper/css/bs-stepper.min.css') }}">
<link href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px !important;
    }

    .ck-editor__editable_inline {
        min-height: 200px;
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
<script src="{{url('adminlte/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('adminlte/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/select2/js/select2.min.js')}}"></script>

<script>
    $(document).ready(function() {
        const berbayar = '<?php echo $dataPerusahaan->berbayar ?>'
        console.log(berbayar)
        if (berbayar === '0') {
            $('.berbayar').hide()
            $('select#select_berbayar').prop('required', false);
            $('input#total_biaya').prop('required', false);
        }
    })

    function handleBerbayar(data) {
        if (data !== 0) {
            $('.berbayar').show();
            $('select#select_berbayar').prop('required', true);
            $('input#total_biaya').prop('required', true);
        } else {
            $('.berbayar').hide();
            $('select#select_berbayar').prop('required', false);
            $('input#total_biaya').prop('required', false);
        }

    }

    let count = 0

    function dinamis() {
        count += 1;
        $("#add_pembayaran").append(`
            <tr id="pembayaran${count}">
                <td>                                    
                    <input type="number" class="form-control" name="termin[]" required>
                </td>
                <td>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" name="persentase[]" required>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-md-10">
                            <select class="form-control" style="float:left" name="output[]" required>
                                <option value="">Silahkan Pilih</option>
                                <option value="Opening Meeting">Opening Meeting</option>
                                <option value="Kunjungan Lapangan">Kunjungan Lapangan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger" name="add" value="${count}" onclick="remove(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        `)
    }

    function remove(data) {
        $(`tr[id="pembayaran${data.value}"]`).remove()
    }

    function removeTable(data) {
        $(`tr[id="produk${data.value}"]`).remove()
    }

    $(document).on('click', '.remove-tr-pengawasan', function() {
        $(this).parents('tr').remove();
    });

    function genTable() {
        const addProduk = $('input[id="add_produk"]').val()
        let view = [],
            lastId = '<?php echo count($produk) ?>'
        if (addProduk > 0 && addProduk !== '') {
            for (let i = 0; i < addProduk; i++) {
                let id = ++lastId
                view.push(`
                    <tr id="produk${id}">
                        <td><input type="text" name="nama_produk[]" class="form-control" ></td>
                        <td><input type="text" name="tipe_produk[]" class="form-control" ></td>
                        <td><input type="text" name="spesifikasi_produk[]" class="form-control" ></td>
                        <td>
                            <button type="button" class="btn btn-danger" name="add" value="${id}" onclick="removeTable(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `)
            }
            $('#produk').append(view)
        } else {
            alert('Mohon input jumlah tambah produk')
        }

    }

    function autofilltagihan(data) {
        $.ajax({
            method: "GET",
            url: "{{url('konfirmasi-order')}}" + '/' + data,
            success: function(data) {
                console.log(data)
                $('textarea[id="alamat_ditagihkan"]').val(data[0].alamat_pusat)
                $('input[id="beban_biaya"]').val(data[0].nama)
            }
        })
    }

    function autofillverif(data) {
        $.ajax({
            method: "GET",
            url: "{{url('konfirmasi-order')}}" + '/' + data,
            success: function(data) {
                $('textarea[id="alamat_diverifikasi"]').val(data[0].alamat_pusat)
            }
        })
    }

    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

    ClassicEditor
        .create(document.querySelector('#editor'), {
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#editor2'), {
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        })
        .catch(error => {
            console.error(error);
        });

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        formatAngka();
    });

    function formatAngka() {
        $('.lahan').inputmask('currency', {
            allowMinus: false,
            radixPoint: ',',
            digits: 4
        })
        $('.uang').inputmask('currency', {
            allowMinus: false,
            radixPoint: ',',
            digits: 2,
            greedy: false,
        })
        $('.persen').inputmask('currency', {
            allowMinus: false,
            radixPoint: ',',
            digits: 2
        })
        $('.formatAngka').inputmask('currency', {
            allowMinus: false,
            radixPoint: ',',
            digits: 0
        })
    }
</script>


@endpush