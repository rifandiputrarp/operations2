@extends('layouts.app')

@section('title','Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fa fa-info"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">Info</span>
        <h4 class="info-box-text">
          <marquee>
            <img src="{{ asset('img/logoscinew.png')}}" alt="Logo" class=" text-center" style="width: 50px"> &nbsp;
            Selamat Datang di Sistem Informasi TKDN
            <img src="{{ asset('img/logoscinew.png')}}" alt="Logo" class=" text-center" style="width: 50px"> &nbsp;
          </marquee>
        </h4>
      </div>
    </div>
  </div>
  @role('Admin|PM|Kemenperin')
  <div class="col-md-12">
    <div class="card card-outline card-success">
      <div class="card-body" id="table1_wrapper">
        <div class="form-group row">
          <label class="col-md-2">Tanggal Mulai</label>
          <div class="col-md-4">
            <input type="text" value="{{$tgl_mulai}}" onchange="getPenugasan()" id="tgl_mulai" class="form-control col-md-8 tanggal" name="tgl_mulai" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
          </div>

          <label class="col-md-2">Tanggal Akhir</label>
          <div class="col-md-4">
            <input type="text" value="{{$tgl_akhir}}" onchange="getPenugasan()" id="tgl_akhir" class="form-control col-md-8 tanggal" name="tgl_akhir" data-toggle="datetimepicker" placeholder="DD/MM/YYYY" autocomplete="off" required />
          </div>
        </div>

        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3 id="total_perusahaan">0</h3>

                  <p>Total Perusahaan</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3 id="total">0</h3>

                  <p>Total Produk</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 id="ditugaskan">0</h3>

                  <p>Total Produk yg Ditugaskan</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="row">
            <div class="col">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3 id="diverifikasi">0</h3>

                  <p>Total Produk yg Sudah Diverifikasi</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3 id="belumTerbit">0</h3>

                  <p>Total Sertifikat Belum Terbit</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col">
              <!-- small box -->
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3 id="sudahTerbit">0</h3>

                  <p>Total Sertifikat Terbit</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
        </div>

      </div>
      <div class="card-body">
        <div class="col-md-12">
          <table id="table1" class="table table-striped table-bordered" style="width:100%">
            <thead class="text-center">
              <tr>
                <th width="30%">Kelompok Barang</th>
                <th>Jumlah Produk</th>
                <th>Jumlah Produk yg Sudah Diverifikasi</th>
                <th>Sertifikat Belum Terbit</th>
                <th>Sertifikat Terbit</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endrole
</div>
@endsection
{{--

@push('css')
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush

@push('js')
<!-- daterangepicker -->
<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- PAGE PLUGINS -->
<!-- ChartJS -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script> -->
<script src="{{ asset('adminlte/dist/js/pages/dashboard3.js') }}"></script>

<script type="text/javascript">
  // The Calender
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  })
</script>
@endpush--}}


@push('js')
@include('layouts.datatable-js')
<script type="text/javascript">
  $(function() {
    getPenugasan();
  });

  function getPenugasan() {
    var tgl_mulai = $('#tgl_mulai').val();
    var tgl_akhir = $('#tgl_akhir').val();
    $.ajax({
      url: "{{url('home/getBox')}}",
      data: {
        "tgl_mulai": tgl_mulai,
        "tgl_akhir": tgl_akhir
      }
    }).done(function(m) {
      var obj = JSON.parse(m);
      $("#total_perusahaan").html(obj.total_perusahaan);
      $("#total").html(obj.total);
      $("#ditugaskan").html(obj.ditugaskan);
      $("#diverifikasi").html(obj.diverifikasi);
      $("#belumTerbit").html(obj.belumTerbit);
      $("#sudahTerbit").html(obj.sudahTerbit);
    }).fail(function(jqXHR, textStatus, error) {
      console.log("error getPenugasan: " + error);
    });

    $("#table1").DataTable({
      searching: false,
      paging: false,
      info: false,
      responsive: true,
      lengthChange: true,
      autoWidth: true,
      "aaSorting": [],
      destroy: true,
      ajax: {
        "url": "{{ url('home/getData') }}",
        "dataSrc": "",
        "data": {
          "tgl_mulai": tgl_mulai,
          "tgl_akhir": tgl_akhir
        }
      },
      columns: [{
          "data": "nama"
        },
        {
          "data": "total_produk"
        },
        {
          "data": "total_produk_sudah_diverifikasi"
        },
        {
          "data": "total_produk_belum_terbit"
        },
        {
          "data": "total_produk_sudah_terbit"
        },
      ]
    })
  }
</script>
@endpush