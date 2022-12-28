@extends('layouts.app')

@section('title','Master Produk')

@section('breadcrumb')
<li class="breadcrumb-item active">Master Produk</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Master Produk</h3>
            </div>
            <div class="card-body">
                
                <form action="{{url('master-produk/post')}}" method="post">
                    {{csrf_field()}}
        
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom:30px">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control" placeholder="Nama Produk" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom:30px">
                                <label>Kode Permen</label>
                                <input type="text" class="form-control" placeholder="Nama Produk" name="kode_permen" required>
                            </div>
                        </div>
                    </div>
                    

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
