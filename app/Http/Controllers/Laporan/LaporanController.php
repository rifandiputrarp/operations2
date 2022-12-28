<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Response;
use URL;
use Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DataTables;
use Session;
use File;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function exportData()
    {
        return view('laporan.view_export_penugasan');
    }

    public function doExportData(Request $request)
    {
        $tgl_awal = implode('-', array_reverse(explode("/", $request->tgl_awal)));
        $tgl_akhir = implode('-', array_reverse(explode("/", $request->tgl_akhir)));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:A2');
        $sheet->setCellValue('A1', 'No');

        $sheet->mergeCells('B1:B2');
        $sheet->setCellValue('B1', 'Perusahaan');

        $sheet->mergeCells('C1:C2');
        $sheet->setCellValue('C1', 'Alamat');

        $sheet->mergeCells('D1:D2');
        $sheet->setCellValue('D1', 'Nomor OC');

        $sheet->mergeCells('E1:E2');
        $sheet->setCellValue('E1', 'Nomor Ref');

        $sheet->mergeCells('F1:F2');
        $sheet->setCellValue('F1', 'Status Berbayar');

        $sheet->mergeCells('G1:J1');
        $sheet->setCellValue('G1', 'Jumlah Produk');
        $sheet->setCellValue('G2', 'Total');
        $sheet->setCellValue('H2', 'Ditugaskan');
        $sheet->setCellValue('I2', 'Telah diverifikasi');
        $sheet->setCellValue('J2', 'Sudah masuk laporan');

        $sheet->mergeCells('K1:L1');
        $sheet->setCellValue('K1', 'Tanggal Penugasan');

        $sheet->setCellValue('K2', 'Awal');
        $sheet->setCellValue('L2', 'Akhir');

        $sheet->mergeCells('M1:N1');
        $sheet->setCellValue('M1', 'Tanggal kunjungan');

        $sheet->setCellValue('M2', 'Awal');
        $sheet->setCellValue('N2', 'Akhir');
        $i = 2;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            )
        ];
        $i = $i - 1;
        //$sheet->getStyle('A1:N2')->applyFromArray($styleArray);

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }/*
        $sheet->getColumnDimension('K')->setWidth(100);
        $sheet->getColumnDimension('L')->setWidth(100);*/

        //value
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
            ->whereDate('p.tgl_mulai', '>=', $tgl_awal)
            ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)
            ->get();
        for ($i = 0; $i < count($query); $i++) {
            $sheet->setCellValue('A' . ($i + 3), $i + 1);
            $sheet->setCellValue('B' . ($i + 3), $query[$i]->nama);
            $sheet->setCellValue('C' . ($i + 3), $query[$i]->alamat . ', ' . $query[$i]->kelurahan . ', ' . $query[$i]->kecamatan . ', ' . $query[$i]->kabupaten . ', ' . $query[$i]->provinsi);
            $sheet->setCellValue('D' . ($i + 3), $query[$i]->nomor);
            $sheet->setCellValue('E' . ($i + 3), $query[$i]->no_ref);
            $sheet->setCellValue('F' . ($i + 3), $query[$i]->berbayar);
            $sheet->setCellValue('G' . ($i + 3), $query[$i]->objek_order);
            $sheet->setCellValue('H' . ($i + 3), $query[$i]->jml_produk);
            $Sudah_Diverifikasi = DB::table('verifikasi_produks')
                ->where('penugasan_id', '=', $query[$i]->id)->get();
            $sheet->setCellValue('I' . ($i + 3), count($Sudah_Diverifikasi));
            $Sudah_Masuk_Laporan = DB::table('laporans as l')
                ->join('laporan_details as d', 'l.id', '=', 'd.laporan_id')
                ->where('penugasan_id', '=', $query[$i]->id)->get();
            $sheet->setCellValue('J' . ($i + 3), count($Sudah_Masuk_Laporan));

            $sheet->setCellValue('K' . ($i + 3), date("d-m-Y", strtotime($query[$i]->tgl_mulai)));
            $sheet->setCellValue('L' . ($i + 3), date("d-m-Y", strtotime($query[$i]->tgl_akhir)));
            $sheet->setCellValue('M' . ($i + 3), date("d-m-Y", strtotime($query[$i]->tgl_surtug)));
            $sheet->setCellValue('N' . ($i + 3), date("d-m-Y", strtotime($query[$i]->tgl_akhir_surtug)));
            //echo $query[$i]->id;
        }
        //endvalue

        $sheet->getStyle('A1:N' . (count($query) + 2))->applyFromArray($styleArray);

        $dt1 = date_create($tgl_awal);
        $dt2 = date_create($tgl_akhir);
        $dt1_format = date_format($dt1, "d-m-Y");
        $dt2_format = date_format($dt2, "d-m-Y");

        $writer = new Xlsx($spreadsheet);
        //        $writer->save('Report .xlsx');

        $extension = 'Xlsx';
        $now = '' . date('d-m-Y');
        //        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, $extension);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"Data Total Produk ({$dt1_format} - {$dt2_format}).{$extension}\"");
        $writer->save('php://output');
        exit();
    }

    public function doExportDataBase(Request $request)
    {
        $tgl_awal = implode('-', array_reverse(explode("/", $request->tgl_awal)));
        $tgl_akhir = implode('-', array_reverse(explode("/", $request->tgl_akhir)));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nomor Referensi');
        $sheet->setCellValue('C1', 'Tanggal TKDN');
        $sheet->setCellValue('D1', 'Badan Perusahaan');
        $sheet->setCellValue('E1', 'Nama Perusahaan');
        $sheet->setCellValue('F1', 'NPWP');
        $sheet->setCellValue('G1', 'Status Perusahaan');
        $sheet->setCellValue('H1', 'Bidang Usaha');
        $sheet->setCellValue('I1', 'Jenis Produk');
        $sheet->setCellValue('J1', 'Tipe');
        $sheet->setCellValue('K1', 'Spesifikasi');
        $sheet->setCellValue('L1', 'Nilai TKDN');
        $sheet->setCellValue('M1', 'Alamat Pusat');
        $sheet->setCellValue('N1', 'Kel Desa Pusat');
        $sheet->setCellValue('O1', 'Kec Pusat');
        $sheet->setCellValue('P1', 'Kab Kodya Pusat');
        $sheet->setCellValue('Q1', 'Provinsi Pusat');
        $sheet->setCellValue('R1', 'Kode Pos Pusat');
        $sheet->setCellValue('S1', 'Telepon Pusat');
        $sheet->setCellValue('T1', 'Fax Pusat');
        $sheet->setCellValue('U1', 'Email Pusat');
        $sheet->setCellValue('V1', 'Alamat Pabrik');
        $sheet->setCellValue('W1', 'Kel Desa Pabrik');
        $sheet->setCellValue('X1', 'Kec Pabrik');
        $sheet->setCellValue('Y1', 'Kab Kodya Pabrik');
        $sheet->setCellValue('Z1', 'Provinsi Pabrik');
        $sheet->setCellValue('AA1', 'Kode Pos Pabrik');
        $sheet->setCellValue('AB1', 'Telepon Pabrik');
        $sheet->setCellValue('AC1', 'Fax Pabrik');
        $sheet->setCellValue('AD1', 'Email Pabrik');
        $sheet->setCellValue('AE1', 'Pejabat Penghubung');
        $sheet->setCellValue('AF1', 'Jabatan');

        $i = 2;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            )
        ];
        $i = $i - 1;

        for ($x = 0; $x <= 32; $x++) {
            $sheet->getColumnDimensionByColumn($x)->setAutoSize(true);
        }

        //value
        $query = DB::table('penugasans as p')
            ->leftJoin('master_perusahaan_alamat as a_pabrik', 'a_pabrik.id', '=', 'p.alamat_id')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'p.perusahaan_id')
            ->leftJoin('master_perusahaan_alamat as a_pusat', function ($join) {
                $join->on('a_pusat.id_perusahaan', '=', 'mp.id');
                $join->where('a_pusat.jenis_kantor', '=', 1);
            })
            ->join('verifikasi_produks as v', 'v.penugasan_id', '=', 'p.id')
            ->join('master_barang_jasa as kelompok', 'kelompok.id', '=', 'v.kelompok_id')
            ->select(
                'p.no_ref',
                'p.tgl_mulai',
                'mp.badan',
                'mp.nama as nama_perusahaan',
                'mp.npwp',
                'mp.status',
                'kelompok.nama',
                'v.bidang_usaha',
                'v.jenis_produk',
                'v.tipe',
                'v.spesifikasi',
                'v.capaian_tkdn',
                'mp.pejabat',
                'mp.jabatan',
                'mp.id as id_perusahaan',
                'a_pabrik.alamat as alamat_pabrik',
                'a_pabrik.kelurahan as kelurahan_pabrik',
                'a_pabrik.kecamatan as kecamatan_pabrik',
                'a_pabrik.kabupaten as kabupaten_pabrik',
                'a_pabrik.provinsi as provinsi_pabrik',
                'a_pabrik.kode_pos as kode_pos_pabrik',
                'a_pabrik.telepon as telepon_pabrik',
                'a_pabrik.fax as fax_pabrik',
                'a_pabrik.email as email_pabrik',
                'a_pusat.alamat as alamat_pusat',
                'a_pusat.kelurahan as kelurahan_pusat',
                'a_pusat.kecamatan as kecamatan_pusat',
                'a_pusat.kabupaten as kabupaten_pusat',
                'a_pusat.provinsi as provinsi_pusat',
                'a_pusat.kode_pos as kode_pos_pusat',
                'a_pusat.telepon as telepon_pusat',
                'a_pusat.fax as fax_pusat',
                'a_pusat.email as email_pusat',
            )
            ->whereDate('p.tgl_mulai', '>=', $tgl_awal)
            ->whereDate('p.tgl_akhir', '<=', $tgl_akhir)
            ->get();
        //dd($query);
        for ($i = 0; $i < count($query); $i++) {
            $sheet->setCellValue('A' . ($i + 2), $i + 1);
            $sheet->setCellValue('B' . ($i + 2), $query[$i]->no_ref);
            $sheet->setCellValue('C' . ($i + 2),  date("d-m-Y", strtotime($query[$i]->tgl_mulai)));
            $sheet->setCellValue('D' . ($i + 2), $query[$i]->badan);
            $sheet->setCellValue('E' . ($i + 2), $query[$i]->nama_perusahaan);
            $sheet->setCellValue('F' . ($i + 2), $query[$i]->npwp);
            $sheet->setCellValue('G' . ($i + 2), $query[$i]->status);
            $sheet->setCellValue('H' . ($i + 2), $query[$i]->bidang_usaha);
            $sheet->setCellValue('I' . ($i + 2), $query[$i]->jenis_produk);
            $sheet->setCellValue('J' . ($i + 2), $query[$i]->tipe);
            $sheet->setCellValue('K' . ($i + 2), $query[$i]->spesifikasi);
            $sheet->setCellValue('L' . ($i + 2), $query[$i]->capaian_tkdn);

            $sheet->setCellValue('M' . ($i + 2), $query[$i]->alamat_pusat);
            $sheet->setCellValue('N' . ($i + 2), $query[$i]->kelurahan_pusat);
            $sheet->setCellValue('O' . ($i + 2), $query[$i]->kecamatan_pusat);
            $sheet->setCellValue('P' . ($i + 2), $query[$i]->kabupaten_pusat);
            $sheet->setCellValue('Q' . ($i + 2), $query[$i]->provinsi_pusat);
            $sheet->setCellValue('R' . ($i + 2), $query[$i]->kode_pos_pusat);
            $sheet->setCellValue('S' . ($i + 2), $query[$i]->telepon_pusat);
            $sheet->setCellValue('T' . ($i + 2), $query[$i]->fax_pusat);
            $sheet->setCellValue('U' . ($i + 2), $query[$i]->email_pusat);
            $sheet->setCellValue('V' . ($i + 2), $query[$i]->alamat_pabrik);
            $sheet->setCellValue('W' . ($i + 2), $query[$i]->kelurahan_pabrik);
            $sheet->setCellValue('X' . ($i + 2), $query[$i]->kecamatan_pabrik);
            $sheet->setCellValue('Y' . ($i + 2), $query[$i]->kabupaten_pabrik);
            $sheet->setCellValue('Z' . ($i + 2), $query[$i]->provinsi_pabrik);
            $sheet->setCellValue('AA' . ($i + 2), $query[$i]->kode_pos_pabrik);
            $sheet->setCellValue('AB' . ($i + 2), $query[$i]->telepon_pabrik);
            $sheet->setCellValue('AC' . ($i + 2), $query[$i]->fax_pabrik);
            $sheet->setCellValue('AD' . ($i + 2), $query[$i]->email_pabrik);
            $sheet->setCellValue('AE' . ($i + 2), $query[$i]->pejabat);
            $sheet->setCellValue('AF' . ($i + 2), $query[$i]->jabatan);
        }
        //endvalue

        $sheet->getStyle('A1:AF' . (count($query) + 1))->applyFromArray($styleArray);
        $sheet->getStyle("A1:AF1")->getFont()->setBold(true);
        $sheet->getStyle('A1:AF1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF7F');

        $dt1 = date_create($tgl_awal);
        $dt2 = date_create($tgl_akhir);
        $dt1_format = date_format($dt1, "d-m-Y");
        $dt2_format = date_format($dt2, "d-m-Y");

        $writer = new Xlsx($spreadsheet);

        $extension = 'Xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"DataBase ({$dt1_format} - {$dt2_format}).{$extension}\"");
        $writer->save('php://output');
        exit();
    }

    public function getList()
    {
        $data = array();
        $query = DB::table('laporans as l')
            ->join('master_perusahaans as p', 'p.id', '=', 'l.perusahaan_id')
            ->join('master_permens as per', 'per.id', '=', 'l.permen_id')
            ->join('laporan_details as ld', 'l.id', '=', 'ld.laporan_id')
            ->join('verifikasi_produks as v', 'v.id', '=', 'ld.ver_produk_id')
            ->select(array('l.id', 'l.no_laporan', 'per.nama_permen', 'p.nama as nama_perusahaan', 'l.tanggal', DB::raw('count(ld.id) as jml_produk')))
            ->groupBy('l.id')
            ->orderBy('l.id', 'DESC')
            ->get();
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($q) {
                $tanggal = implode("/", array_reverse(explode("-", $q->tanggal)));
                return $tanggal;
            })
            ->make(true);
        for ($i = 0; $i < count($query); $i++) {
            $row["no"] = ($i + 1);
            $row["id"] = $query[$i]->id;
            $row["kelompok"] = $query[$i]->kelompok_id;
            $row["bidang_usaha"] = $query[$i]->bidang_usaha;
            $row["jenis_produk"] = $query[$i]->jenis_produk;
            $row["tipe"] = $query[$i]->tipe;
            $row["spesifikasi"] = $query[$i]->spesifikasi;
            if ($query[$i]->nama_file == "") {
                $row["file"] = '<center>-</center>';
                $row["status"] = '<center><i><span class="badge badge-warning">N/A</span></i></center>';
            } else {
                $row["file"] = $query[$i]->nama_file;
                $row["status"] = '<center><i><span class="badge badge-success">Telah Diverifikasi</span></i></center>';
            }
            $row["action"] = '<div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox">
                          <label class="form-check-label"></label>
                        </div>
                      </div>';
            $data['data'][] = $row;
        }
        return response()->json($data, 200);
    }

    public function view($penugasan_id)
    {
        $penugasan = DB::table('penugasans')->find($penugasan_id);
        $permen = DB::table('master_permens')->find($penugasan->permen_id);
        return view('laporan.view')->with(compact('penugasan_id', 'permen'));
    }

    public function getData()
    {
        $role = Auth::user()->getRoleNames();
        $role = $role[0];
        $data = [];
        $query = DB::table('laporans as l')
            ->join('laporan_details as ld', 'l.id', '=', 'ld.laporan_id')
            ->join('penugasans as pg', 'l.penugasan_id', '=', 'pg.id')
            ->leftjoin('master_perusahaans as p', 'l.perusahaan_id', '=', 'p.id')
            ->leftjoin('master_permens as mp', 'l.permen_id', '=', 'mp.id')
            ->select(array(
                'l.id', 'l.no_laporan', 'l.tanggal', 'mp.nama_permen', 'mp.id as permen_id', 'l.name_cover', 'pg.no_ref', 'l.no_sertifikat', 'l.file_sertifikat',
                DB::raw('CONCAT(COALESCE(p.badan,"")," ",p.nama,"<small>(",COALESCE(p.alamat_pabrik,""),")</small>") as nama_perusahaan'),
            ))
            ->groupBy('l.id')
            ->get();
        $data['data'] = array();
        if (count($query) > 0) {
            $no = 1;
            foreach ($query as $idx => $value) {
                $tanggal = implode("/", array_reverse(explode("-", $value->tanggal)));
                $row["no"] = ($no++);
                $row["id"] = $value->id;
                $row["no_ref"] = '<center>' . $value->no_ref . '</center>';
                $row["no_laporan"] = '<center><b>' . $value->no_laporan . '</b></center>';
                $row["nama_perusahaan"] = $value->nama_perusahaan;
                $row["tanggal"] = '<center>' . $tanggal . '</center>';
                if ($value->name_cover == "") {
                    $row["name"] = "<center><i>N/A</i></center>";
                } else {
                    $row["name"] = '<a href="' . URL::to('laporan/downloadCover/' . $value->id) . '">' . $value->name_cover . '</a>';
                }

                if ($value->file_sertifikat == "") {
                    $row["no_sertifikat"] = "<center><i>$value->no_sertifikat</i></center>";
                } else {
                    $row["no_sertifikat"] = '<center><a href="' . URL::to('laporan/downloadSertifikat/' . $value->id) . '">' . $value->no_sertifikat . '</a></br>
                                               <i style="cursor: pointer;color:red;" title="hapus sertifikat" class="fa fa-trash mx-1" onclick="delete_sertifikat(\'' . $value->id . '\', \'' . $value->no_sertifikat . '\')"></i></center>';
                    //                    <a href="' . URL::to('laporan/deleteSertifikat/' . $value->id) . '"><i class="fa fa-trash mx-1"></i></a>';
                }
                $row["action"] = '<div class="btn-group-vertical">';
                if ($role == "Admin" || $role == "QC") {
                    $row["action"] .= '
                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-id="' . $value->id . '" onclick="tesnil(' . $value->id . ')" data-target="#modal-surtug"><i class="fa fa-plus"></i> Upload Cover</a>
                            <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-id="' . $value->id . '" onclick="setVal(' . $value->id . ', ' . $value->no_sertifikat . ')" data-target="#modal-upload-sertifikat"><i class="fa fa-plus"></i> Upload Sertifikat</a>
                            <a target="_blank" href="' . URL::to('cetak-laporan/' . $value->id) . '" class="btn btn-sm btn-success"><i class="fa fa-file-pdf"></i> Cetak</a>
                            ';
                }
                $row["action"] .= "</div>";

                $data['data'][] = $row;
            }
        }

        return response()->json($data, 200);
    }

    public function upload(Request $request)
    {
        $name = $request->cover->getClientOriginalName();
        $id = $request->id;
        $path = Storage::putFile(
            'public/cover',
            $request->file('cover'),
        );

        $update = DB::table('laporans')
            ->where('id', '=', $id)
            ->update([
                'cover_path' => $path,
                'name_cover' => $name
            ]);

        return redirect('laporan');
    }

    public function uploadSertifikat(Request $request)
    {
        $no_sertifikat = $request->no_sertifikat;
        //$name = $request->file_sertifikat->getClientOriginalName();
        $id = $request->id;
        $path = Storage::putFile(
            'public/sertifikat',
            $request->file('file_sertifikat'),
        );

        $update = DB::table('laporans')
            ->where('id', '=', $id)
            ->update([
                'file_sertifikat' => $path,
                'no_sertifikat' => $no_sertifikat
            ]);

        return redirect('laporan');
    }

    public function createNew(Request $request)
    {
        $no_laporan = $request->no_laporan;
        $penugasan_id = $request->penugasan_id;
        $dasar_hukum = $request->dasar_hukum;
        $tgl_laporan = implode("-", array_reverse(explode("/", $request->tgl_laporan)));
        $penugas = DB::table('penugasans')->where('id', $penugasan_id)->first();
        $permen = DB::table('master_permens')->where('id', $penugas->permen_id)->first();
        $oc = DB::table('konfirmasi_orders')->where('id', $penugas->oc_id)->first();
        $statusBayar = @$oc->berbayar;
        if ($statusBayar == 1) {
            $no_laporan = "TKDN";
        } else {
            $no_laporan = "PTKDN";
        }
        $no_laporan_db = $no_laporan;
        $no_laporan .= ' - ' . $permen->kode_permen;
        $tahun = date("y", strtotime($tgl_laporan));
        $menu = 'laporan';
        $getSeq = DB::table('master_sequence')
            ->where('menu', $menu)
            ->where('tahun', $tahun)
            ->where('tipe', $no_laporan_db)
            ->get();

        if (!isset($getSeq[0])) {
            $nomor = "1";
            $nomor = sprintf("%05d", $nomor);
            DB::table('master_sequence')
                ->insert(['menu' => $menu, 'tahun' => $tahun, 'nomor' => $nomor, 'tipe' => $no_laporan_db]);
        } else {
            $nomor = ($getSeq[0]->nomor + 1);
            $nomor = sprintf("%05d", $nomor);
            DB::table('master_sequence')
                ->where('menu', $menu)
                ->where('tahun', $tahun)
                ->where('tipe', $no_laporan_db)
                ->update(['nomor' => $nomor]);
        }
        $no_laporan .= ' - ' . $tahun . $nomor;
        $getVerProd = DB::table('verifikasi_produks')->where('penugasan_id', $penugasan_id)->get();
        $insert = array(
            'no_laporan' => $no_laporan,
            'permen_id' => $penugas->permen_id,
            'perusahaan_id' => $oc->id_perusahaan_diverifikasi,
            'penugasan_id' => $penugasan_id,
            'tanggal' => $tgl_laporan,
            'dasar_hukum' => $dasar_hukum,
        );
        $lap_id = DB::table('laporans')->insertGetId($insert);
        foreach ($request->produk_id as $key => $value) {
            $insertDetail = array(
                'laporan_id' => $lap_id,
                'ver_produk_id' => $value
            );
            DB::table('laporan_details')->insert($insertDetail);
        }
        Session::flash('success', 'Data Berhasil Dimasukkan');
        return redirect('verifikasi/viewLaporan/' . $penugasan_id);
    }

    public function downloadCover($id)
    {
        $laporan = DB::table('laporans')->find($id);
        $file = storage_path('app/' . $laporan->cover_path);
        return Response::download($file, $laporan->name_cover);
    }

    public function downloadSertifikat($id)
    {
        $laporan = DB::table('laporans')->find($id);
        $file = storage_path('app/' . $laporan->file_sertifikat);
        return Response::download($file, $laporan->no_sertifikat);
    }

    public function deleteSertifikat($id)
    {
        $laporan = DB::table('laporans')->find($id);
        $file = storage_path('app/' . $laporan->file_sertifikat);

        File::delete($file);
        $update = DB::table('laporans')
            ->where('id', '=', $id)
            ->update([
                'file_sertifikat' => null,
                'no_sertifikat' => null
            ]);

        return redirect('laporan')->with('status', 'Data berhasil Dihapus');;
    }
}
