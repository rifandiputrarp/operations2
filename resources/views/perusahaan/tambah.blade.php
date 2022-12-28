@extends('layouts.app')

@section('title','Pengajuan')

@section('breadcrumb')
<li class="breadcrumb-item">Pengajuan</li>
<li class="breadcrumb-item active">Tambah</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
            <h3 class="card-title">Tambah Pengajuan Baru</h3>
            </div>
            <div class="card-body">
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#step1">
                            <button type="button" class="step-trigger" role="tab" aria-controls="step1" id="step1-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Pilih Perusahaan</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#step2">
                            <button type="button" class="step-trigger" role="tab" aria-controls="step2" id="step3-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Data Produk yang Diverifikasi</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <form action="{{url('pengajuan/save')}}" method="post">
                        @csrf
                            <div id="step1" class="content" role="tabpanel" aria-labelledby="step1-trigger">
                                <div class="form-group row">
                                    <label class="col-md-3">Nama Perusahaan</label>
                                    <div class="col-md-9">
                                        <select class="form-control">
                                            <option>-PILIH-</option>
                                            <option>PT. APPIPA INDONESIA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3">Jumlah Produk Yang Akan Diverifikasi</label>
                                    <div class="col-md-9">
                                        <input type="number" name="" class="form-control">
                                    </div>
                                </div>
                            
                                <button type="button" class="btn btn-primary" onclick="stepper.next()">Selanjutnya</button>
                            </div>
                            <div id="step2" class="content" role="tabpanel" aria-labelledby="step2-trigger">
                                
                                <div class="row">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th colspan="2" class="text-center bg-navy">DATA PRODUK 1</th>
                                        </tr>
                                        <tr>
                                            <td> Kelompok Barang/Jasa </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>-PILIH-</option>
                                                    @foreach($kelompok as $kel)
                                                    <option>{!! $kel->nama !!}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Bidang Usaha </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>-PILIH-</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Jenis Produk </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>-PILIH-</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th colspan="2" class="text-center bg-navy">DATA PRODUK 2</th>
                                        </tr>
                                        <tr>
                                            <td> Kelompok Barang/Jasa </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>-PILIH-</option>
                                                    @foreach($kelompok as $kel)
                                                    <option>{!! $kel->nama !!}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Bidang Usaha </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>-PILIH-</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Jenis Produk </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>-PILIH-</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>   
                                <button type="button" class="btn btn-primary" onclick="stepper.previous()">Kembali</button>
                                <div class="btn-group float-right">
                                    <button type="submit" class="btn btn-primary">Simpan ke Draft</button>
                                    <button type="submit" class="btn btn-success">Simpan & Kirim</button>    
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- /.card -->
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/bs-stepper/css/bs-stepper.min.css') }}">
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
<script src="{{asset('adminlte/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<script>
       document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script>
@endpush