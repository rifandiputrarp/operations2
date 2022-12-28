@extends('layouts.app')

@section('title','Konfirmasi Order')

@section('breadcrumb')
<li class="breadcrumb-item active">Konfirmasi Order</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Form Konfirmasi Order</h3>
            </div>
            <form action="{{url('konfirmasi-order/post')}}" method="post">
                <div class="card-body">
                    {{csrf_field()}}
                    <table class="table table-borderless">
                        <tr>
                            <th style="width:25%">Status Pembayaran</th>
                            <td colspan="5">
                                <input type="radio" required name="berbayar" value="0" onclick="handleBerbayar(0)"> Tidak Berbayar
                                &nbsp;
                                <input type="radio" required name="berbayar" value="1" onclick="handleBerbayar(1)"> Berbayar
                            </td>
                        </tr>
                        <tr>
                            <th>Perusahaan yang Diverifikasi</th>
                            <td colspan="3">
                                <select class="form-control select2bs4" name="id_perusahaan_diverifikasi" style="width:100%" onchange="autofillverif(this.value)" required>
                                    <option value="">Please Select</option>
                                    @foreach($data as $g)
                                    <option value="{{$g->id}}">{{$g->nama}}</option>
                                    @endforeach
                                </select>
                                <small><i>Apabila tidak ditemukan, silahkan tambah Perusahaan <a href="{{url('/master-perusahaan/tambah/oc')}}">di sini</a></i></small>
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat Perusahaan yang diverifikasi</th>
                            <td colspan="5">
                                <textarea class="form-control" id="alamat_diverifikasi" id="alamat_diverifikasi" readonly></textarea>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Perusahaan yang Ditagihkan</th>
                            <td colspan="3">
                                <select class="form-control select2bs4" id="select_berbayar" name="id_perusahaan_ditagihkan" style="width:100%" onchange="autofilltagihan(this.value)" required>
                                    <option value="">Please Select</option>
                                    @foreach($data as $g)
                                    <option value="{{$g->id}}">{{$g->nama}}</option>
                                    @endforeach
                                </select>
                                <small><i>Apabila tidak ditemukan, silahkan tambah Perusahaan <a href="{{url('/master-perusahaan/tambah/oc')}}">di sini</a></i></small>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Alamat yang Ditagihkan</th>
                            <td colspan="5">
                                <textarea class="form-control" id="alamat_ditagihkan" id="alamat_ditagihkan" readonly></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Nomor</th>
                            <td colspan="5">
                                <input class="form-control col-md-3" name="nomor" value="-">
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal OC</th>
                            <td colspan="5">
                                <input type="text" class="form-control col-md-3 tanggal" data-toggle="datetimepicker" name="tanggal" placeholder="DD/MM/YYYY" autocomplete="off" value="{{$tgl_now}}" />
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Jenis Jasa</th>
                            <td colspan="5">
                                <input class="form-control" name="jenis_jasa" value="Verifikasi Tingkat Komponen Dalam Negeri (TKDN)" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah Produk</th>
                            <td>
                                <div class="input-group " style="width:30%">
                                    <input type="number" class="form-control" name="objek_order" oninput="genTable(this.value)" min="1" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Produk</span>
                                    </div>
                                </div>
                            </td>
                            <td colspan="4">
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Waktu Pelaksanaan</th>
                            <td>
                                <div class="input-group " style="width:30%">
                                    <input type="number" class="form-control" min="1" name="waktu_pelaksanaan">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Hari Kerja</span>
                                    </div>
                                </div>
                            </td>
                            <td colspan="4">
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Keterangan</th>
                            <td colspan="5">
                                <textarea name="keterangan" id="editor"></textarea>
                            </td>
                        </tr>

                        <tr class="berbayar">
                            <th>Total Biaya</th>
                            <td>
                                <input type="number" class="form-control col-md-4 input_berbayar" id="total_biaya" min="0" max="100000000000000" oninput="changeUang(this.value)" autocomplete="off" />
                                <div class="input-group col-md-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" readonly id="total_biaya_read" value="0" />
                                </div>
                            </td>
                            <td colspan="4">
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>
                                Pembayaran
                            </th>
                            <td colspan="5">
                                <table class="table table-bordered text-center">
                                    <tr>
                                        <th width="10%">Termin</th>
                                        <th width="20%">Persentase</th>
                                        <th>Output</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="number" class="form-control" name="termin[]" readonly value="1">
                                        </td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="persentase[]">
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
                                                        <option value="Opening Meeting/Kunjungan Lapangan">Opening Meeting/Kunjungan Lapangan</option>
                                                        <option value="Laporan Terbit">Laporan Terbit</option>
                                                        <option value="Sertifikat Terbit">Sertifikat Terbit</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-success" name="add" onclick="dinamis()">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tbody id="add_pembayaran"></tbody>
                                </table>
                            </td>
                        </tr>
                        <tr class="berbayar">
                            <th>Seluruh Biaya dibebankan kepada</th>
                            <td colspan="5"> <input class="form-control" name="dibebankan_kepada" id="beban_biaya" value="-"></td>
                        </tr>
                        <tr class="berbayar">
                            <th>Referensi</th>
                            <td colspan="5">
                                <textarea name="referensi" id="editor2"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Rincian Produk
                            </th>
                            <td colspan="5">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama/Jenis Produk</th>
                                            <th>Tipe Produk</th>
                                            <th>Spesifikasi Produk</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dummy">
                                        <tr>
                                            <td colspan="5" style="text-align: center"> Silahkan lengkapi jumlah objek order</td>
                                        </tr>
                                    </tbody>
                                    <tbody id="produk">
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

@push('js')
<script src="{{url('adminlte/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/ckeditor/ckeditor.js')}}"></script>

<script>
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

    $(document).ready(function() {
        formatAngka();
        $('#tgl1').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });

    let count = 0

    function dinamis() {
        count += 1;
        $("#add_pembayaran").append(`
            <tr id="pembayaran${count}">
                <td>                                    
                    <input type="number" class="form-control" name="termin[]" readonly value="${count+1}">
                </td>
                <td>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" name="persentase[]">
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
                                <option value="Laporan Terbit">Laporan Terbit</option>
                                <option value="Sertifikat Terbit">Sertifikat Terbit</option>
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
        console.log(data)
        $(`tr[id="pembayaran${data.value}"]`).remove()
    }

    $(document).on('click', '.remove-tr-pengawasan', function() {
        $(this).parents('tr').remove();
    });

    function genTable(data) {
        let view = []
        if (data > 0 && data !== '') {
            for (let i = 0; i < data; i++) {
                view.push(`
                    <tr>
                        <td>${ i + 1}</td>
                        <td><input type="text" name="nama_produk[]" class="form-control" ></td>
                        <td><input type="text" name="tipe_produk[]" class="form-control" ></td>
                        <td><input type="text" name="spesifikasi_produk[]" class="form-control" ></td>
                    </tr>
                `)
            }
            $('#dummy').hide()
            $('#produk').html(view)
        } else {
            $('#dummy').show()
            $('#produk').html('')
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

    ClassicEditor
        .create(document.querySelector('#editor'), {
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', ],
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#editor2'), {
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', ],
        })
        .catch(error => {
            console.error(error);
        });

    function formatAngka() {
        $('.uang').inputmask('currency', {
            allowMinus: false,
            radixPoint: ',',
            digits: 2,
            greedy: false,
        })
    }

    function changeUang(uang) {
        // var uang = uang.replace(",00", "");
        // var reverse = uang.toString().split('.')
        // var real = reverse.join('');
        // console.log(reverse);
        // console.log(real);
        // $('#total_biaya_hidden').val(real);

        var reverse = uang.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        $('#total_biaya_read').val(ribuan);
    }
</script>


@endpush