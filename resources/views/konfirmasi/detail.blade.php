@extends('layouts.app')

@section('title','Konfirmasi Order')

@section('breadcrumb')
<li class="breadcrumb-item">Konfirmasi Order</li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Detail Konfirmasi Order</h3>
            </div>
            <div class="card-body p-0">
                {{csrf_field()}}

                <table class="table">
                    <tr>
                        <th width="25%">Status Pembayaran</th>
                        <td width="75%" colspan="5">
                            {{@$dataPerusahaan->berbayar === 0 ? 'Tidak Berbayar' : 'Berbayar'}}
                        </td>
                    </tr>
                    <tr class="berbayar">
                        <th width="25%">Perusahaan yang Ditagihkan</th>
                        <td width="75%" colspan="5">
                            {{@$alamat_tagihan[0]->nama}}
                        </td>
                    </tr>
                    <tr class="berbayar">
                        <th>Alamat yang Ditagihkan</th>
                        <td colspan="5">
                            {{@$alamat_tagihan[0]->alamat_pusat}}
                        </td>
                    </tr>
                    <tr>
                        <th>Perusahaan yang Diverifikasi</th>
                        <td colspan="5">
                            {{$alamat_verifikasi[0]->nama}}
                        </td>
                    </tr>
                    <tr>
                        <th>Alamat Perusahaan yang diverifikasi</th>
                        <td colspan="5">
                            {{$alamat_verifikasi[0]->alamat_pusat}}
                        </td>
                    </tr>
                    <tr>
                        <th>Nomor</th>
                        <td colspan="5">
                            {{$dataPerusahaan->nomor}}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td colspan="5">
                            {{$dataPerusahaan->tanggal}}
                        </td>
                    </tr>
                    <tr class="berbayar">
                        <th>Jenis Jasa</th>
                        <td colspan="5">
                            Verifikasi Tingkat Komponen Dalam Negeri (TKDN)
                        </td>
                    </tr>
                    <th>Objek Order</th>
                    <td colspan="5">
                        {{$dataPerusahaan->objek_order}}
                    </td>
                    <tr class="berbayar">
                        <th>Waktu Pelaksanaan</th>
                        <td colspan="5">
                            {{$dataPerusahaan->waktu_pelaksanaan}} Hari Kerja

                        </td>
                    <tr class="berbayar">
                        <th>Keterangan</th>
                        <td colspan="5">
                            {!! $dataPerusahaan->keterangan !!}
                        </td>
                    <tr class="berbayar">
                        <th>Total Biaya</th>
                        <td colspan="5">
                            Rp {{$dataPerusahaan->total_biaya}}
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
                                <tr>
                                    <td>
                                        {{$data->termin}}
                                    </td>
                                    <td>
                                        {{$data->persentase}} %
                                    </td>
                                    <td>
                                        {{$data->output}}
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <tr class="berbayar">
                        <th>Seluruh Biaya dibebankan kepada</th>
                        <td colspan="5"> {{$dataPerusahaan->dibebankan_kepada}}</td>
                    </tr>
                    <tr class="berbayar">
                        <th>Referensi</th>
                        <td colspan="5">
                            {!! $dataPerusahaan->keterangan !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Produk yang di verifikasi
                        </th>
                        <td colspan="5">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama/Jenis Produk</th>
                                        <th>Tipe Produk</th>
                                        <th>Spesifikasi Produk</th>
                                    </tr>
                                </thead>

                                <tbody id="produk">
                                    @foreach($produk as $idx => $data)
                                    <tr id="produk{{$idx}}">
                                        <td>{{$data->nama_produk}}</td>
                                        <td>{{$data->tipe_produk}}</td>
                                        <td>{{$data->spesifikasi_produk}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer text-muted">
                <a href="{{url('konfirmasi-order')}}" class="btn btn-default">Kembali</a>
            </div>
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
        }
    })

    let count = 0

    function dinamis() {
        count += 1;
        $("#add_pembayaran").append(`
            <tr id="pembayaran${count}">
                <td>Termin</td>
                <td>                                    
                    <input type="number" class="form-control" name="termin[]" readonly>
                </td>
                <td>Persentase</td>
                <td>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" name="persentase[]" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </td>
                <td>Output</td>
                <td>
                    <div class="row">
                        <div class="col-md-10">
                            <select class="form-control" style="float:left" name="output[]" readonly>
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
                        <td><input type="text" name="nama_produk[]" class="form-control" readonly></td>
                        <td><input type="text" name="tipe_produk[]" class="form-control" readonly></td>
                        <td><input type="text" name="spesifikasi_produk[]" class="form-control" readonly></td>
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