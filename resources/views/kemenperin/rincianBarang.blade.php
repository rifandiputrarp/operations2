@extends('layouts.app')

@section('title','Status Sertifikasi Perusahaan Penyedia Barang')

@section('breadcrumb')
<li class="breadcrumb-item active">Status Sertifikasi Perusahaan Penyedia Barang</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Rincian Status Sertifikat TKDN</h3>
            </div>
            <div class="card-body">
                <div class="container" style="overflow: auto;max-width:100%">
                    <p>Nama Perusahaan      :    {{ $dataPerusahaan[0]->badan }}. {{ $dataPerusahaan[0]->nama }}</p>
                    <p>Alamat Perusahaan    :  {{ $dataPerusahaan[0]->alamat_pusat }}</p>
                    <table id="example" class="table table-striped table-bordered datatable">
                        <thead>
                            <tr>
                                <th> No </th>
                                <th> Nomor Laporan </th>
                                <th> Peraturan Menteri </th>
                                <th> Tanggal </th>
                                <th> Status </th>
                                <th> Nomor Sertifikat </th>
                                <th> Aksi </th>
                            </tr>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($dataSertifikatPerusahaan as $key)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $key->no_laporan }}</td>
                                <td>{{ $key->nama_permen }}</td>
                                <td>{{ $key->tanggal }}</td>
                                <td>
                                    @if ($key->no_sertifikat != NULL && $key->file_sertifikat != NULL)
                                        <span class="badge badge-success"><i class="fas fa-check"></i> &nbsp; Pengajuan TKDN Berhasil! </span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-info"></i> &nbsp; Sedang Dalam Tahap Verifikasi. </span>
                                    @endif
                                </td>
                                <td>{{ $key->no_sertifikat }}</td>
                                <td>
                                        @if ($key->no_sertifikat != NULL && $key->file_sertifikat != NULL)
                                        <a href="/laporan/downloadSertifikat/{{ $key->id }}" class="btn btn-sm btn-success" style="margin-top:5px;"">
                                            <i class="fas fa-eye"></i> &nbsp;Lihat Sertifikat TKDN
                                        </a><br>
                                    @else
                                        <a href="#" class="btn btn-sm btn-warning" style="margin-top:5px;">
                                            <i class="fas fa-info"></i> &nbsp;Masih dalam tahap Verifikasi.
                                        </a><br>    
                                    @endif
                                </td>
                            </tr>
                            @php
                                $i += 1;
                            @endphp
                            @endforeach
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection