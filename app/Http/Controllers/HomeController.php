<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $year = date('Y');
        $tgl_mulai = "01/01/" . $year;
        $tgl_akhir = "31/12/" . $year;
        // $kelompok = DB::table('')
        return view('home', compact('tgl_mulai', 'tgl_akhir'));
    }

    public function getBox()
    {
        $tgl_mulai = implode('-', array_reverse(explode("/", $_GET['tgl_mulai'])));
        $tgl_akhir = implode('-', array_reverse(explode("/", $_GET['tgl_akhir'])));

        $query = DB::table('penugasans as p')
            ->join('konfirmasi_orders as k', 'k.id', '=', 'p.oc_id')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'p.perusahaan_id')
            ->leftjoin('master_perusahaan_alamat as mpa', 'mpa.id', '=', 'p.alamat_id')
            ->leftjoin('surat_tugas as st', 'st.penugasan_id', '=', 'p.id')
            ->select(
                'mp.nama',
                'mpa.alamat',
                'mpa.kelurahan',
                'mpa.kecamatan',
                'mpa.kabupaten',
                'mpa.provinsi',
                'k.nomor',
                'p.no_ref',
                'k.berbayar',
                'k.objek_order',
                'p.jml_produk',
                'p.tgl_mulai',
                'p.tgl_akhir',
                'st.tgl_surtug',
                'st.tgl_akhir_surtug',
                'p.id'
            )
            ->whereDate('p.tgl_mulai', '>=', $tgl_mulai)
            ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)
            ->get();

        $total = 0;
        $ditugaskan = 0;
        $diverifikasi = 0;
        $belumTerbit = 0;
        $sudahTerbit = 0;
        for ($i = 0; $i < count($query); $i++) {
            $Sudah_Diverifikasi = DB::table('verifikasi_produks')
                ->whereNotNull('capaian_tkdn')
                ->where('penugasan_id', '=', $query[$i]->id)->get();
            $belum_terbit = DB::table('laporans as l')
                ->join('laporan_details as d', 'l.id', '=', 'd.laporan_id')
                ->whereNull('no_sertifikat')
                ->where('penugasan_id', '=', $query[$i]->id)->get();
            $sudah_terbit = DB::table('laporans as l')
                ->join('laporan_details as d', 'l.id', '=', 'd.laporan_id')
                ->whereNotNull('no_sertifikat')
                ->where('penugasan_id', '=', $query[$i]->id)->get();

            $total = $total + $query[$i]->objek_order;
            $ditugaskan = $ditugaskan + $query[$i]->jml_produk;
            $diverifikasi = $diverifikasi + count($Sudah_Diverifikasi);
            $belumTerbit = $belumTerbit + count($belum_terbit);
            $sudahTerbit = $sudahTerbit + count($sudah_terbit);
        }

        $row = array();
        $row['total_perusahaan'] = count($query);
        $row['total'] = $total;
        $row['ditugaskan'] = $ditugaskan;
        $row['diverifikasi'] = $diverifikasi;
        $row['belumTerbit'] = $belumTerbit;
        $row['sudahTerbit'] = $sudahTerbit;

        echo json_encode($row);
    }

    public function getData()
    {
        $tgl_mulai = implode('-', array_reverse(explode("/", $_GET['tgl_mulai'])));
        $tgl_akhir = implode('-', array_reverse(explode("/", $_GET['tgl_akhir'])));

        $data = [];
        $query = DB::table('master_barang_jasa as mbj')
            ->select('mbj.*')
            ->orderBy('mbj.nama', 'ASC')
            ->get();

        $grand_total_produk = 0;
        $grand_total_produk_sudah_diverifikasi = 0;
        $grand_total_produk_belum_terbit = 0;
        $grand_total_produk_sudah_terbit = 0;
        for ($i = 0; $i < count($query); $i++) {
            $row["nama"] = $query[$i]->nama;

            $total_produk = DB::table('master_barang_jasa as m')
                ->join('verifikasi_produks as v', 'v.kelompok_id', '=', 'm.id')
                ->join('penugasans as p', 'p.id', '=', 'v.penugasan_id')
                ->where('m.id', '=', $query[$i]->id)
                ->whereDate('p.tgl_mulai', '>=', $tgl_mulai)
                ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)->get();
            $row["total_produk"] = '<p style="text-align: right">' . count($total_produk) . '</p>';
            $grand_total_produk = $grand_total_produk + count($total_produk);

            $total_produk_sudah_diverifikasi = DB::table('master_barang_jasa as m')
                ->join('verifikasi_produks as v', 'v.kelompok_id', '=', 'm.id')
                ->join('penugasans as p', 'p.id', '=', 'v.penugasan_id')
                ->where('m.id', '=', $query[$i]->id)
                ->whereNotNull('v.capaian_tkdn')
                ->whereDate('p.tgl_mulai', '>=', $tgl_mulai)
                ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)->get();
            $row["total_produk_sudah_diverifikasi"] = '<p style="text-align: right">' . count($total_produk_sudah_diverifikasi) . '</p>';
            $grand_total_produk_sudah_diverifikasi = $grand_total_produk_sudah_diverifikasi + count($total_produk_sudah_diverifikasi);

            $total_produk_belum_terbit = DB::table('master_barang_jasa as m')
                ->join('verifikasi_produks as v', 'v.kelompok_id', '=', 'm.id')
                ->join('laporan_details as ld', 'ld.ver_produk_id', '=', 'v.id')
                ->join('laporans as l', 'l.id', '=', 'ld.laporan_id')
                ->join('penugasans as p', 'p.id', '=', 'v.penugasan_id')
                ->where('m.id', '=', $query[$i]->id)
                ->whereNull('l.no_sertifikat')
                ->whereDate('p.tgl_mulai', '>=', $tgl_mulai)
                ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)->get();
            $row["total_produk_belum_terbit"] = '<p style="text-align: right">' . count($total_produk_belum_terbit) . '</p>';
            $grand_total_produk_belum_terbit = $grand_total_produk_belum_terbit + count($total_produk_belum_terbit);

            $total_produk_sudah_terbit = DB::table('master_barang_jasa as m')
                ->join('verifikasi_produks as v', 'v.kelompok_id', '=', 'm.id')
                ->join('laporan_details as ld', 'ld.ver_produk_id', '=', 'v.id')
                ->join('laporans as l', 'l.id', '=', 'ld.laporan_id')
                ->join('penugasans as p', 'p.id', '=', 'v.penugasan_id')
                ->where('m.id', '=', $query[$i]->id)
                ->whereNotNull('l.no_sertifikat')
                ->whereDate('p.tgl_mulai', '>=', $tgl_mulai)
                ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)->get();
            $row["total_produk_sudah_terbit"] =  '<p style="text-align: right">' . count($total_produk_sudah_terbit) . '</p>';
            $grand_total_produk_sudah_terbit = $grand_total_produk_sudah_terbit + count($total_produk_sudah_terbit);

            $data[] = $row;
        }

        $row["nama"] = "<b><center> Belum Dikategorikan </center></b>";
        $belum_dikategorikan = DB::table('verifikasi_produks as v')
            ->join('penugasans as p', 'p.id', '=', 'v.penugasan_id')
            ->whereNull('v.kelompok_id')
            ->whereDate('p.tgl_mulai', '>=', $tgl_mulai)
            ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)->get();
        $row["total_produk"] = '<p style="text-align: right">' . count($belum_dikategorikan) . '</p>';
        $row["total_produk_sudah_diverifikasi"] = '<center>-</center>';
        $row["total_produk_belum_terbit"] = '<center>-</center>';
        $row["total_produk_sudah_terbit"] = '<center>-</center>';
        $grand_total_produk = $grand_total_produk + count($belum_dikategorikan);
        $data[] = $row;
        // dd($belum_dikategorikan);


        $row["nama"] = "<b><center> Grand Total </center></b>";
        $row["total_produk"] = '<p style="text-align: right"><b>' . $grand_total_produk . '</b></p>';
        $row["total_produk_sudah_diverifikasi"] = '<p style="text-align: right"><b>' . $grand_total_produk_sudah_diverifikasi . '</b></p>';
        $row["total_produk_belum_terbit"] = '<p style="text-align: right"><b>' . $grand_total_produk_belum_terbit . '</b></p>';
        $row["total_produk_sudah_terbit"] =  '<p style="text-align: right"><b>' . $grand_total_produk_sudah_terbit . '</b></p>';
        $data[] = $row;

        return response()->json($data, 200);
    }
}
