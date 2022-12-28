<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Sucofindo - TKDN') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}"> -->
  <script src="https://kit.fontawesome.com/3e09340d0f.js" crossorigin="anonymous"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark" style="background-color: #202856;">
    <!-- Left navbar links -->
    <!-- <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">TKDN</a>
      </li>
    </ul> -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link" role="button" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fa fa-sign-out-alt text-danger"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-3" style="background-color: #202856;" >
    <!-- Brand Logo -->
    <a href="#" class="brand-link text-center" style="background-color: #202856;" >
      <img src="{{ asset('img/logoscinew.png')}}" alt="Logo" class=" text-center" style="width: 50px">
      &nbsp;
      <span class="brand-text font-weight-light"><b>TKDN</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('adminlte/dist/img/default-150x150.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          @section('sidebar')
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @role('Kemenperin')
          <li class="nav-item">
            <a href="{{url('status-sertifikat-barang')}}" class="nav-link">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Status Permohonan Sertifikasi Perusahaan
              </p>
            </a>
          </li>
          @endrole
          @role('Admin|Marketing|Kabagpenjualan|PM')
          <li class="nav-item">
            <a href="{{url('konfirmasi-order')}}" class="nav-link">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Konfirmasi Order
              </p>
            </a>
          </li>
          @endrole
          @role('Admin|PM')
          <li class="nav-item">
            <a href="{{url('tugas')}}" class="nav-link">
              <i class="nav-icon fas fa-user-check"></i>
              <p>
                Penugasan Verifikator
              </p>
            </a>
          </li>
          @endrole
          @role('Admin')
          <li class="nav-item">
            <a href="{{url('surtug')}}" class="nav-link">
              <i class="nav-icon fas fa-user-check"></i>
              <p>
                Surat Tugas
              </p>
            </a>
          </li>
          @endrole
          @role('Admin|PM|Verifikator|ETC')
          <li class="nav-item">
            <a href="{{url('verifikasi')}}" class="nav-link">
              <i class="nav-icon fas fa-check-double"></i>
              <p>
                Verifikasi
              </p>
            </a>
          </li>
          @endrole
          @role('Admin|PM|QC')
          <li class="nav-item">
            <a href="{{url('laporan')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Laporan
              </p>
            </a>
          </li>
          @endrole
          @role('Admin|PM|QC')
          <li class="nav-item">
            <a href="{{url('exportData')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                 Export Data
              </p>
            </a>
          </li>
          @endrole
          @role('Admin')
          <li class="nav-header">Pengaturan</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Pengaturan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                  <i class="fa fa-user-cog nav-icon"></i>
                  <p>Manajemen User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link">
                  <i class="fa fa-dot-circle nav-icon"></i>
                  <p>Manajemen Role</p>
                </a>
              </li>
            </ul>
          </li>
          @endrole
          @role('Admin|PM|Verifikator|ETC')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('master-perusahaan')}}" class="nav-link">
                  <i class="fa fa-table nav-icon"></i>
                  <p>Perusahaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('master-barang-jasa')}}" class="nav-link">
                  <i class="fa fa-table nav-icon"></i>
                  <p>Kelompok Barang/Jasa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('permenperin')}}" class="nav-link">
                  <i class="fa fa-table nav-icon"></i>
                  <p>Peraturan Pemerintah</p>
                </a>
              </li>
            </ul>
          </li>
          @endrole
          <li class="nav-header"></li>
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <i class="fa fa-sign-out-alt text-danger"></i>
              <p class="text">
               &nbsp; Logout
              </p>
            </a>
          </li>
          @show
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('title')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              @yield('breadcrumb')
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Selamat Datang !</h5>
      <p>Selamat Datang di Sistem TKDN</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      SCI TKDN
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021 <a href="#">Sucofindo</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- input mask -->
<!-- <script src="{{ asset('adminlte/plugins/inputmask/jquery.inputmask.min.js') }}"></script> -->

@yield('additionalScripts')  

<script>

  $(function () {
      $('.select2').select2()
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      $('.tanggal').datetimepicker({
        format: 'DD/MM/YYYY'
      });

      @if(Session::has('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{Session::get("success") }}',
      })
      @endif

      @if(Session::has('error'))
      Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        text: "{{Session::get('error')}}",
      })
      @endif
  });

  function klikDelete(nameForm){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      // type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        $(nameForm).submit();
      }
    })
  }

  function klikApprove(nameForm){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Approve'
    }).then((result) => {
      if (result.value) {
        Swal.fire({
          title: 'Approved!',
          html: 'Your file has been approved.',
          type: 'success',
          timer: '1000',
          willClose: () => {
            $(nameForm).submit();
          }
        })
      }
    })
  }


</script>

@stack('js')
</body>
</html>
