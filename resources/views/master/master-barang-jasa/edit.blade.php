@extends('layouts.app')

@section('title','Penugasan')

@section('breadcrumb')
<li class="breadcrumb-item active">Penugasan</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Penugasan</h3>
            </div>
            <div class="card-body">
                
            <form action="{{ url('master-barang-jasa/update/'.$data[0]->id) }}" method="POST">
    	        @csrf
                @method('PUT')
                    <div class="form-group" style="margin-bottom:30px">
                        <label>Nama Barang/Jasa</label>
                        <input type="text" class="form-control" placeholder="Nama Barang/Jasa" name="nama" value="{{@$data[0]->nama}}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
