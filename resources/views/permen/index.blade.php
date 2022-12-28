@extends('layouts.app')

@section('title','Master Peraturan Menteri')

@section('breadcrumb')
<li class="breadcrumb-item active">Peraturan Menteri</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Permenperin</h3>
            </div>
            <div class="card-body">
                <table id="table1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peraturan Menteri</th>
                            <th>Dasar Hukum</th>
                            @role('Admin|PM')
                            <th></th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masterPermen as $key => $value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value->nama_permen}}</td>
                            <td>{!! $value->dasar_hukum !!}</td>
                            @role('Admin|PM')
                            <td>
                                <div class="btn-group-vertical">
                                    <a href="#" data-toggle="modal" data-target="#modal-editdasarhukum" data-id="{{$value->id}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit Dasar Hukum</a>
                                </div>
                            </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modal-editdasarhukum" class="modal fade text-center" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Dasar Hukum</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{url('permenperin/editDasarHukum')}}" method="POST">
                @csrf
                <input type="hidden" id="permen_id" name="permen_id" value="">
                <div class="form-group row" style="text-align:left">
                    <label class="col-md-3">Dasar Hukum</label>
                    <div class="col-md-9">
                        <textarea id="dasar_hukum" name="dasar_hukum" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection

@push('css')
@include('layouts.datatable-css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@push('js')
@include('layouts.datatable-js')
<!-- Summernote -->
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
$(document).ready(function() {
  $('#dasar_hukum').summernote({
    height: 150,
    toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        // ['font', ['fontname']],
        // ['fontsize', ['fontsize']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ],
    // fontNames: ['Arial'],
    lineHeights: ['2.0']
  });
  $('#dasar_hukum').summernote('lineHeights', 2);

  var table1 = $('#table1').DataTable();


    $('#modal-editdasarhukum').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') 
        var modal = $(this)
        $('#permen_id').val(id);
        if ($('#dasar_hukum').summernote('isEmpty')) {
        }
        else{
            $('#dasar_hukum').summernote('code', '')
        }

        $.ajax({
            url: "{{url('permenperin/getDataEdit')}}",
            data: {'id':id}
        }).done(function(m){
            var obj = JSON.parse(m);
            $('#dasar_hukum').summernote('pasteHTML', obj.dasar_hukum);
        })
    });
});
</script>
@endpush