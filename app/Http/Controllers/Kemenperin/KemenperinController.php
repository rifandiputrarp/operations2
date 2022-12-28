<?php

namespace App\Http\Controllers\Kemenperin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;
use URL;
use Auth;
use PDF;
Use Session;

class KemenperinController extends Controller
{
    public function indexBarang(){
        return view('kemenperin.indexBarang');
    }

    public function getDataBarang(){
        $dataPerusahaan = DB::table('master_perusahaans')
                            ->get();
        return DataTables::of($dataPerusahaan)
        ->addColumn('action', function($datatb){
            return
            '<a href="'.URL::to('status-sertifikat-barang/rincian/'.$datatb->id).'" class="btn btn-sm btn-success" style="margin-top:5px;"">
                <i class="fas fa-eye"></i> &nbsp;Lihat Status Sertifikat TKDN
            </a><br>';
        })
        ->addColumn('status', function($datatb){
            $countSertifikat = DB::table('laporans')
                                ->where('perusahaan_id','=',$datatb->id)
                                ->count();
            $countSertifikatSelesai = DB::table('laporans')
                                        ->where('perusahaan_id','=',$datatb->id)
                                        ->whereNotNull('file_sertifikat')
                                        ->count();

            $status =   '<span class="badge badge-secondary"><i class="fas fa-info"></i> &nbsp; Jumlah Sertifikat TKDN Diajukan : '.$countSertifikat.'</span> <br>'.
                        '<span class="badge badge-secondary"><i class="fas fa-info"></i> &nbsp; Jumlah Sertifikat TKDN Selesai : '.$countSertifikatSelesai.'</span> <br>';

            return $status;
        })
        ->addIndexColumn()
        ->rawColumns(['action' => 'action', 'status' => 'status'])
        ->make(true);
    }

    public function rincianBarang($id){
        $dataPerusahaan = DB::table('master_perusahaans')
                            ->where('id',$id)
                            ->get();
        
        $dataSertifikatPerusahaan = DB::table('laporans AS l')
                    ->join('penugasans AS p','p.id','=','l.penugasan_id')
                    ->join('master_permens AS mp','mp.id','=','l.permen_id')
                    ->join('master_perusahaans AS usaha','usaha.id','=','l.perusahaan_id')
                    ->where('l.perusahaan_id','=',$id)
                    ->select('l.id','l.no_laporan','mp.nama_permen','l.tanggal','l.no_sertifikat','l.file_sertifikat')
                    ->get();

        return view('kemenperin.rincianBarang', compact('dataPerusahaan','dataSertifikatPerusahaan'));
        
    }

}

