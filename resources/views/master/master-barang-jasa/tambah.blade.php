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
                <h3 class="card-title">Tambah Master Barang/Jasa</h3>
            </div>
            <div class="card-body">
                
                <form action="{{url('master-barang-jasa/post')}}" method="post">
                    {{csrf_field()}}
        
                    <div class="form-group" style="margin-bottom:30px">
                        <label>Nama Barang/Jasa</label>
                        <input type="text" class="form-control" placeholder="Nama Barang/Jasa" name="nama" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
