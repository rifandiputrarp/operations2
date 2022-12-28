<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Response;
use URL;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use LynX39\LaraPdfMerger\Facades\PdfMerger;

class CetakLaporanController extends Controller
{
    public function index(Request $request, $id, $tipe = "")
    {
        // dd($request);
        if ($tipe != "previewDraft") {
            $laporan = DB::table('laporans as l')
                ->select('l.permen_id', 'l.penugasan_id', 'l.dasar_hukum')
                ->where('l.id', '=', $id)
                ->get();

            $permen = $laporan[0]->permen_id;
            $penugasan_id = $laporan[0]->penugasan_id;
        } else {
            $laporan = array();
            @$laporan[0]->dasar_hukum = $request->dasar_hukum;
            $penugasan_id = $request->penugasan_id;
            $getPenugasan = DB::table('penugasans')->find($penugasan_id);
            $permen = $getPenugasan->permen_id;
        }

        // penugasan
        $penugasan = DB::table('penugasans as p')
            ->leftjoin('users as u1', 'u1.id', '=', 'p.verifikator1')
            ->leftjoin('users as u2', 'u2.id', '=', 'p.verifikator2')
            ->leftjoin('users as uetc', 'uetc.id', '=', 'p.etc')
            ->where('p.id', $penugasan_id)
            ->get(array('p.tgl_mulai', 'p.no_ref', 'p.check_self', 'p.nilai_self', 'p.jml_vendor', 'p.jml_bahan_baku', 'u1.name as v1', 'u2.name as v2', 'uetc.name as etc', 'u1.inisial as inisial_v1', 'u2.inisial as inisial_v2', 'uetc.inisial as inisial_etc', 'perusahaan_id', 'perusahaan_lokal_id', 'perusahaan_pengembang_id', 'p.alamat_id', 'p.alamat_lokal_id', 'p.alamat_pengembang_id'));
        $tgl_mulai = $penugasan[0]->tgl_mulai;
        $etc = $penugasan[0]->inisial_etc;
        $verifikator1 = $penugasan[0]->inisial_v1;
        $verifikator2 = $penugasan[0]->inisial_v2;
        $perusahaan_id = $penugasan[0]->perusahaan_id;
        $perusahaan_lokal_id = $penugasan[0]->perusahaan_lokal_id;
        $perusahaan_pengembang_id = $penugasan[0]->perusahaan_pengembang_id;
        $no_ref = $penugasan[0]->no_ref;
        $alamat_id = $penugasan[0]->alamat_id;
        $alamat_lokal_id = $penugasan[0]->alamat_lokal_id;
        $alamat_pengembang_id = $penugasan[0]->alamat_pengembang_id;

        // master permen
        $masterPermen = DB::table('master_permens')
            ->where('id', '=', $permen)
            ->get();

        // get perusahaan utama
        $profil = DB::table('master_perusahaans as mp')
            ->leftjoin('tbl_kelurahan as u1', 'u1.id', '=', 'mp.kode_kelurahan_pusat')
            ->leftjoin('tbl_kecamatan as u2', 'u2.id', '=', 'mp.kode_kecamatan_pusat')
            ->leftjoin('tbl_kota_kab as u3', 'u3.id', '=', 'mp.kode_kabupaten_pusat')
            ->leftjoin('tbl_provinsi as u4', 'u4.id', '=', 'mp.kode_provinsi_pusat')
            ->where('mp.id', '=', $perusahaan_id)
            ->select('mp.*', DB::raw('CONCAT(COALESCE(badan,"")," ",nama) as nama_perusahaan'), 'u1.desa_kelurahan', 'u2.kecamatan', 'u3.kota', 'u4.provinsi')
            ->get();
        $alamat = DB::table('master_perusahaan_alamat as mpa')
            ->where('mpa.id', '=', $alamat_id)
            ->get();
        $alamat_pusat = DB::table('master_perusahaan_alamat as mpa')
            ->where('mpa.id_perusahaan', '=', $perusahaan_id)
            ->where('jenis_kantor', "1")
            ->get();

        // get perusahaan lokal
        $profilLokal = DB::table('master_perusahaans as mp')
            ->where('mp.id', '=', $perusahaan_lokal_id)
            ->select('mp.*', DB::raw('CONCAT(COALESCE(badan,"")," ",nama) as nama_perusahaan'))
            ->get(array('mp.*'));
        $alamat_lokal = DB::table('master_perusahaan_alamat as mpa')
            ->where('mpa.id', '=', $alamat_lokal_id)
            ->get();
        $alamat_lokal_pusat = DB::table('master_perusahaan_alamat as mpa')
            ->where('mpa.id_perusahaan', '=', $perusahaan_lokal_id)
            ->where('jenis_kantor', "1")
            ->get();

        // get perusahaan pengembang
        $profilPengembang = DB::table('master_perusahaans as mp')
            ->where('mp.id', '=', $perusahaan_pengembang_id)
            ->select('mp.*', DB::raw('CONCAT(COALESCE(badan,"")," ",nama) as nama_perusahaan'))
            ->get(array('mp.*'));
        $alamat_pengembang = DB::table('master_perusahaan_alamat as mpa')
            ->where('mpa.id', '=', $alamat_pengembang_id)
            ->get();
        $alamat_pengembang_pusat = DB::table('master_perusahaan_alamat as mpa')
            ->where('mpa.id_perusahaan', '=', $perusahaan_pengembang_id)
            ->where('jenis_kantor', "1")
            ->get();

        $perusahaan_standar = DB::table('master_perusahaan_standars')->where('perusahaan_id', $profil[0]->id)->get();

        // Konfirmasi Order
        $oc = DB::table('penugasans as pg')
            ->join('konfirmasi_orders as ko', 'pg.oc_id', '=', 'ko.id')
            ->select('ko.berbayar', 'ko.tanggal')
            ->where('pg.id', '=', $penugasan_id)
            ->get();

        // get tahun

        $tahunLaporan = DB::table('laporans as l')
            ->select(DB::raw('year(l.tanggal) as tahun'))
            ->where('l.id', '=', $id)
            ->first();

        //get tahun
        $tahunLaporan = DB::table('laporans as l')
        ->select(DB::raw('year(l.tanggal) as tahun'))
        ->where('l.id', '=', $id)
        ->first();

        // surat tugas
        $surtug = DB::table('surat_tugas')->where('penugasan_id', $penugasan_id)->first();

        // data verifikasi produk

        if ($tipe != "previewDraft") {
            $dataVerif = DB::table('laporans as l')
                ->join('laporan_details as ld', 'l.id', '=', 'ld.laporan_id')
                ->join('verifikasi_produks as vp', 'vp.id', '=', 'ld.ver_produk_id')
                ->join('master_barang_jasa as m', 'm.id', 'vp.kelompok_id')
                ->select('vp.*', 'l.cover_path', 'm.nama as nama_kelompok')
                ->where('l.id', '=', $id)
                ->get();

            $hitungDataVerif = count($dataVerif);

            $dataFiles = DB::table('laporans as l')
                ->join('laporan_details as ld', 'l.id', '=', 'ld.laporan_id')
                ->join('verifikasi_produks as vp', 'vp.id', '=', 'ld.ver_produk_id')
                ->join('verifikasi_produk_files as vpf', 'vpf.ver_produk_id', '=', 'vp.id')
                ->join('master_barang_jasa as m', 'm.id', 'vp.kelompok_id')
                ->select('vpf.konten', 'vpf.jenis_id', 'vp.*', 'l.permen_id', 'l.cover_path', 'm.nama as nama_kelompok')
                ->where('l.id', '=', $id)
                ->orderBy('vpf.jenis_id', 'ASC')
                ->get();
        } else {
            $produk_id = implode(", ", $request->produk_id);
            $dataVerif = DB::table('verifikasi_produks as vp')
                ->join('master_barang_jasa as m', 'm.id', 'vp.kelompok_id')
                ->select('vp.*', DB::raw("'' as cover_path"), 'm.nama as nama_kelompok')
                ->whereRaw('vp.id in (' . $produk_id . ')')
                ->get();

            $hitungDataVerif = count($dataVerif);

            $dataFiles = DB::table('verifikasi_produks as vp')
                ->join('verifikasi_produk_files as vpf', 'vpf.ver_produk_id', '=', 'vp.id')
                ->join('master_barang_jasa as m', 'm.id', 'vp.kelompok_id')
                ->join('penugasans as p', 'p.id', '=', 'vp.penugasan_id')
                ->select('vpf.konten', 'vpf.jenis_id', 'vp.*', 'p.permen_id', DB::raw("'' as cover_path"), 'm.nama as nama_kelompok')
                ->whereRaw('vp.id in (' . $produk_id . ')')
                ->orderBy('vpf.jenis_id', 'ASC')
                ->get();
        }


        $dataProduk = array();
        $form19 = 'form1.9';
        if ($permen == 1) {
            foreach ($dataFiles as $idx => $files) {
                $cek = json_decode($files->konten);
                $cek = $cek->$form19;
                $row['dataExcel'] = $cek;
                $dataProduk[] = $row;
            }
        } elseif ($permen == 2) {
            foreach ($dataFiles as $idx => $files) {
                $cek = json_decode($files->konten);
                $row['manufaktur'] = $cek->$form19;
                $row['pengembangan'] = $cek->pengembangan;
                $row['rekapitulasi'] = $cek->rekapitulasi;
                $dataProduk[] = $row;
            }
        } elseif ($permen == 3) {
            foreach ($dataFiles as $idx => $files) {
                $cek = json_decode($files->konten);
                $row['rekapitulasi'] = $cek->rekapitulasi;
                $dataProduk[] = $row;
            }
        } elseif ($permen == 4) {
            foreach ($dataFiles as $idx => $files) {
                $cek = json_decode($files->konten);
                $row['formhitung'] = $cek->formhitung;
                $dataProduk[] = $row;
            }
        } elseif ($permen == 5) {
            foreach ($dataFiles as $idx => $files) {
                $cek = json_decode($files->konten);
                $row['manufaktur'] = $cek->manufaktur;
                $row['pengembangan'] = $cek->pengembangan;
                $row['software'] = $cek->software;
                $row['rekap'] = $cek->rekap;

                $row['manufaktur']['kdn'] = ($row['rekap'][3][2] * 100);
                $row['manufaktur']['kln'] = 100 - ($row['rekap'][3][2] * 100);
                $row['pengembangan']['kdn'] = ($row['rekap'][4][2] * 100);
                $row['pengembangan']['kln'] = 100 - ($row['rekap'][4][2] * 100);
                $row['software']['kdn'] = ($row['rekap'][5][2] * 100);
                $row['software']['kln'] = 100 - ($row['rekap'][5][2] * 100);
                if ($row['rekap'][1][10] == "true") {
                    $row['manufaktur']['tkdn'] = ($row['rekap'][3][5] * 100);
                    $row['pengembangan']['tkdn'] = ($row['rekap'][4][5] * 100);
                    $row['software']['tkdn'] = ($row['rekap'][5][5] * 100);
                } else {
                    $row['manufaktur']['tkdn'] = ($row['rekap'][3][7] * 100);
                    $row['pengembangan']['tkdn'] = ($row['rekap'][4][7] * 100);
                    $row['software']['tkdn'] = ($row['rekap'][5][7] * 100);
                }
                $row['rekap']['tkdn'] = ($row['rekap'][6][4] * 100);
                $dataProduk[] = $row;
            }
        } elseif ($permen == 6) {
            $dataFiles = json_decode($dataFiles);
            foreach ($dataFiles as $idx => $files) {
                $jenis_file = DB::table('master_jenis_file as mjf')
                    ->select('mjf.*')
                    ->where('mjf.id', '=', $files->jenis_id)
                    ->where('mjf.jenis_kbl', '=', $files->jenis_kbl)
                    ->where('mjf.permen_id', '=', $files->permen_id)
                    ->get();
                $files->nama_jenis = $jenis_file[0]->nama_jenis;
            }
        }
        $namaFile = 'Laporan ' . $profil[0]->nama_perusahaan . '-' . $no_ref . '-' . time() . '.pdf';


        $sendData = compact('tahunLaporan', 'laporan', 'dataVerif', 'hitungDataVerif', 'verifikator1', 'etc', 'profil', 'profilLokal', 'profilPengembang', 'dataProduk', 'dataFiles', 'perusahaan_standar', 'oc', 'surtug', 'masterPermen', 'penugasan', 'alamat', 'alamat_lokal', 'alamat_pengembang', 'alamat_pusat', 'alamat_lokal_pusat', 'alamat_pengembang_pusat');

        $sendData = compact('tahunLaporan','laporan', 'dataVerif', 'verifikator1', 'etc', 'profil', 'profilLokal', 'profilPengembang', 'dataProduk', 'dataFiles', 'perusahaan_standar', 'oc', 'surtug', 'masterPermen', 'penugasan', 'alamat', 'alamat_lokal', 'alamat_pengembang', 'alamat_pusat', 'alamat_lokal_pusat', 'alamat_pengembang_pusat');

        switch ($permen) {
            case 1:
                $pdf = PDF::loadview('laporan.cetak_permen_1', $sendData);
                break;
            case 2:
                $pdf = PDF::loadview('laporan.cetak_permen_2', $sendData);
                break;
            case 3:
                $pdf = PDF::loadview('laporan.cetak_permen_3', $sendData);
                break;
            case 4:
                $pdf = PDF::loadview('laporan.cetak_permen_4', $sendData);
                break;
            case 5:
                $pdf = PDF::loadview('laporan.cetak_permen_5', $sendData);
                break;
            default:
                //for load pdf on the fly
                $pdf = PDF::loadview('laporan.cetak_permen_6', $sendData);
        }

        // Lampiran
        if ($tipe != "previewDraft") {
            $lampiran = DB::table('laporan_lampirans')->where('laporan_id', $id)->get();
        } else {
            $lampiran = array();
        }

        $cover = $dataVerif[0]->cover_path;
        $namaFile = $namaFile;
        if ($tipe == "preview") {
            Storage::put('public/pdf/' . $namaFile, $pdf->output());
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF(storage_path('app/public/pdf/' . $namaFile), 'all');
            foreach ($lampiran as $key => $value) {
                $pdfMerger->addPDF($value->path . $value->nama_file, 'all');
            }
            $pdfMerger->merge();
            $pdfMerger->save($namaFile, "output");
        } else {
            Storage::put('public/pdf/' . $namaFile, $pdf->output());
            $pdfMerger = PDFMerger::init();
            if ($cover != "") {
                $pdfMerger->addPDF(storage_path('app/' . $cover), 'all');
            }
            $pdfMerger->addPDF(storage_path('app/public/pdf/' . $namaFile), 'all');
            foreach ($lampiran as $key => $value) {
                $pdfMerger->addPDF($value->path . $value->nama_file, 'all');
            }
            $pdfMerger->merge();
            $pdfMerger->save($namaFile, "output");
        }
        exit(0);
    }
}
