@extends('layouts.app')

@section('title','Users Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Users Management</li>
@endsection


@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Users Management</h3>
        </div>
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
              <p>{{ $message }}</p>
            </div>
          @endif
          <a href="{{ url('users/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data</a>
          <br><br>
          <table id="table1" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Inisial</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $user)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->inisial }}</td>
                  <td>
                    @if(!empty($user->getRoleNames()))
                      @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                      @endforeach
                    @endif
                  </td>
                  <td>
                    <!-- <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"><i class="fa fa-eye"></i> Show</a> -->
                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                    <a href="#" onclick="klikDelete('formdel{{$user->id}}')" class="btn btn-sm btn-outline-danger text-left">
                        <i class="fa fa-trash"></i>&nbsp; Delete
                    </a>
                    <form id="formdel{{$user->id}}" method="POST" action="{{url('user/delete/'.$user->id)}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
@include('layouts.datatable-css')
@endpush

@push('js')
    @include('layouts.datatable-js')
    <script>
   $(document).ready( function () {
    $('#table1').DataTable();
} );
    </script>
@endpush