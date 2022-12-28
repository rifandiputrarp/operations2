@extends('layouts.app')

@section('title','Master Barang/Jasa')

@section('breadcrumb')
<li class="breadcrumb-item active">Master Barang-Jasa</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Master Barang/Jasa</h3>
            </div>
            <div class="card-body">

                <form action="{{ url('penugasan/update/'.$id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="oc_id" value="{{$penugasan[0]->oc_id}}">
                    <div class="form-group" style="margin-bottom:30px">
                        <label>No Referensi</label>
                        <input type="text" class="form-control col-md-4" autocomplete="off" disabled value="{{@$penugasan[0]->no_ref}}" />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom:30px">
                                <label>Tanggal Mulai Pelaksanaan</label>
                                <input type="text" class="form-control tanggal" data-toggle="datetimepicker" name="tgl_mulai" placeholder="DD/MM/YYYY" autocomplete="off" required value="{{ date('d/m/Y',strtotime(@$penugasan[0]->tgl_mulai)) }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom:30px">
                                <label>Tanggal Selesai Pelaksanaan</label>
                                <input type="text" class="form-control tanggal" data-toggle="datetimepicker" name="tgl_akhir" placeholder="DD/MM/YYYY" autocomplete="off" required value="{{ date('d/m/Y',strtotime(@$penugasan[0]->tgl_akhir)) }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom:30px">
                                <label>Total Produk</label>
                                <input type="text" class="form-control" autocomplete="off" readonly name="total_produk" value="{{$oc[0]->objek_order}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom:30px">
                                <label>Jumlah Produk yang Diverifikasi</label>
                                <input type="number" class="form-control" name="jml_produk" required min="1" required max="{{$oc[0]->objek_order}}" value="{{@$penugasan[0]->jml_produk}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-md-6">
                            <label>Verifikator 1</label>
                            <select class="form-control select2bs4" required name="verifikator[]">
                                <option value="">-PILIH-</option>
                                @foreach($verifikator as $key)
                                <option value="{{$key->id}}" <?php if (@$penugasan[0]->verifikator1 === $key->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Verifikator 2</label>
                            <select class="form-control select2bs4" name="verifikator[]">
                                <option value="">-PILIH-</option>
                                @foreach($verifikator as $key)
                                <option value="{{$key->id}}" <?php if (@$penugasan[0]->verifikator2 === $key->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-md-6">
                            <label>Verifikator 3</label>
                            <select class="form-control select2bs4" name="verifikator[]">
                                <option value="">-PILIH-</option>
                                @foreach($verifikator as $key)
                                <option value="{{$key->id}}" <?php if (@$penugasan[0]->verifikator3 === $key->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Verifikator 4</label>
                            <select class="form-control select2bs4" name="verifikator[]">
                                <option value="">-PILIH-</option>
                                @foreach($verifikator as $key)
                                <option value="{{$key->id}}" <?php if (@$penugasan[0]->verifikator4 === $key->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row my-4">
                        <div class="col-md-6">
                            <label>Verifikator 5</label>
                            <select class="form-control select2bs4" name="verifikator[]">
                                <option value="">-PILIH-</option>
                                @foreach($verifikator as $key)
                                <option value="{{$key->id}}" <?php if (@$penugasan[0]->verifikator5 === $key->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-md-6">
                            <label>ETC</label>
                            <select class="form-control select2bs4" required name="etc">
                                <option value="">-PILIH-</option>
                                @foreach($etc as $key)
                                <option value="{{$key->id}}" <?php if (@$penugasan[0]->etc === $key->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection