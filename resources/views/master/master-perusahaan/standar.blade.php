@extends('layouts.app')

@section('title','Master Perusahaan')

@section('breadcrumb')
<li class="breadcrumb-item">Master Perusahaan</li>
<li class="breadcrumb-item active">Standar</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Standar</h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-6">Penerapan Sistem Manajemen dan Standarisasi &nbsp; <button type="button" id="addRow" class="btn btn-sm btn-success">Tambah</button></label>
                    <div class="col-md-12">
                        <form method="POST" action="{{url('master-perusahaan/simpanStandar')}}">
                            @csrf
                            <input type="hidden" name="perusahaan_id" value="{{$id}}">
                            <table id="tableStandar" class="table table-sm table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Jenis Standar</th>
                                        <th>No Sertifikat</th>
                                        <th>Tanggal</th>
                                        <th>Badan Sertifikat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getStandar as $val)
                                    <tr>
                                        <td><input type="text" name="jenis_standar[]" class="form-control" value="{{$val->jenis_standar}}" /></td>
                                        <td><input type="text" name="no_sertifikat[]" class="form-control" value="{{$val->no_sertifikat}}" /></td>
                                        <td>
                                            <div class="col-md-12">
                                                <input type="text" name="tanggal[]" class="form-control tanggal" data-toggle="datetimepicker" value="{{ date('d/m/Y',strtotime($val->tanggal)) }}" />
                                            </div>
                                        </td>
                                        <td><input type="text" name="badan_sertifikat[]" class="form-control" value="{{$val->badan_sertifikat}}" /></td>
                                        <td><a href="#" class="btn btn-danger deleterow">Delete</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-lg btn-block btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
    $(function() {

        var t = $('#tableStandar').DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: false,
        });
        var counter = 1;



        $('#addRow').on('click', function() {
            t.row.add([
                '<input type="text" name="jenis_standar[]" class="form-control" />',
                '<input type="text" name="no_sertifikat[]" class="form-control" />',
                '<div class="col-md-12">' +
                '<input type="text" class="form-control" id="tgl' + counter + '" data-toggle="datetimepicker" placeholder="(DD/MM/YYYY)" name="tanggal[]" value="" autocomplete="off"> ' +
                '</div>',
                '<input type="text" name="badan_sertifikat[]" class="form-control" />',
                '<a href="#" class="btn btn-danger deleterow">Delete</a>',
            ]).draw(false);
            $('#tgl' + counter).datetimepicker({
                format: 'DD/MM/YYYY',
                container: '#tgl' + counter
            });

            counter++;
        });

        // $('#addRow').click();

        $('#tableStandar tbody').on('click', '.deleterow', function() {
            t
                .row($(this).parents('tr'))
                .remove()
                .draw();
        });
    })
</script>
@endpush