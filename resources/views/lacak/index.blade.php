@extends('layouts.app')

@section('title','Lacak')

@section('breadcrumb')
<li class="breadcrumb-item active">Lacak</li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
            <h3 class="card-title">Lacak Status Perusahaan</h3>
            </div>
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr style="text-align:center">
                            <th rowspan="2" style="vertical-align:middle">Perusahaan</th>
                            <th colspan="5" style="text-align: center">Status</th>
                        </tr>
                        <tr style="text-align:center">
                            <th>Registrasi</th>
                            <th>Penugasan</th>
                            <th>Verifikasi</th>
                            <th>QA</th>
                            <th>Publish</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PT. APIPA INDONESIA</td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                        </tr>
                        <tr>
                            <td>PT. X</td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center">Waiting</td>
                        </tr>
                        <tr>
                            <td>PT. Y</td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center">Waiting</td>
                            <td style="text-align:center">Waiting</td>
                        </tr>
                        <tr>
                            <td>PT. Z</td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center"><i class="fas fa-check"></i></td>
                            <td style="text-align:center">Waiting</td>
                            <td style="text-align:center">Waiting</td>
                            <td style="text-align:center">Waiting</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- lacak -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lacak Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12" style="padding:0 50px">
                <ul class="timeline" id="isi">
                    <li>
                        <span class="text-success">(19/08/2021 09:03)
                        Pengajuan telah disetujui oleh PM</span>
                    </li>
                    <li class="passed">
                        <span class="text-gray">(18/08/2021 15:34)
                        Pengajuan berhasil ditambahkan. Menunggu Persetujuan dari PM.</span>
                    </li>
                </ul>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endpush
<!-- <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script> -->
@push('js')
    <script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>

    <script>
        $(function () {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush