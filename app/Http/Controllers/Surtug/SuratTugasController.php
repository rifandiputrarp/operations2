<?php

namespace App\Http\Controllers\Surtug;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use URL;
use App\Models\KonfirmasiOrder;
use App\Models\KonfirmasiOrderProduk;
use App\Models\Pembayaran;
use App\Models\User;
use Auth;
use Session;
// use Spatie\Permission\Models\Role;

class SuratTugasController extends Controller
{

    public function index(){
        $verifikator = User::role(['Verifikator','ETC'])->orderBy('users.name')->get();
        return view('surtug.index')->with(compact('verifikator'));
    }

    public function getSurtug(){
      $data = [];
      $penugasan = DB::table('penugasans as p')
              ->join('master_perusahaans as per','per.id','=','p.perusahaan_id')
              ->leftjoin('surat_tugas as st','st.penugasan_id','=','p.id')
              ->leftjoin('surat_tugas_details as std','std.surat_tugas_id','=','st.id')
              ->leftjoin('users as ust','ust.id','=','std.user_id')
              ->leftjoin('users as u1','u1.id','=','p.verifikator1')
              ->leftjoin('users as u2','u2.id','=','p.verifikator2')
              ->leftjoin('users as u3','u3.id','=','p.verifikator3')
              ->leftjoin('users as u4','u4.id','=','p.verifikator4')
              ->leftjoin('users as u5','u5.id','=','p.verifikator5')
              ->leftjoin('users as uetc','uetc.id','=','p.etc')
              ->leftjoin('users as upm','upm.id','=','p.pm')
              ->groupBy('p.id')
              ->select('p.*','u1.name as v1','u2.name as v2','u3.name as v3','u4.name as v4','u5.name as v5','uetc.name as uetc','upm.name as upm','st.tgl_surtug','st.tgl_akhir_surtug','st.no_surat',DB::raw('GROUP_CONCAT(ust.name SEPARATOR ",<br>") as name_surtug'),DB::raw('CONCAT(COALESCE(per.badan,"")," ",per.nama,"<small>(",COALESCE(per.alamat_pabrik,""),")</small>") as nama'))
              ->orderBy('p.id','DESC')
              ->get();

      // dd($query);
      if(count($penugasan)>0){
        $ver = '<ol style="padding-left:20px">';
        $e = $ver;
        foreach($penugasan as $idx => $penugasan){
            $tgl_surtug = implode("/",array_reverse(explode("-",$penugasan->tgl_surtug)));
            $tgl_akhir_surtug = implode("/",array_reverse(explode("-",$penugasan->tgl_akhir_surtug)));
            $row["no"] = ($idx+1);
            $row["id"] = $penugasan->id;
            $row["no_ref"] = '<a href="#" data-toggle="modal" data-target="#modal-viewpenugasan" data-penugasan_id="'.$penugasan->id.'"> '.$penugasan->no_ref.'</a>';
            $row["nama_perusahaan"] = $penugasan->nama;
            if ($penugasan->no_surat == "") {
                $row["no_surat"] = '<center><span class="badge badge-warning">Belum Ada Surat Tugas</span></center>';
                $row["tgl_surtug"] = '<center></center>';
                $row["tgl_akhir_surtug"] = '<center></center>';
            }else{
                $row["no_surat"] = '<center><b>'.$penugasan->no_surat.'</b></center>';
                $row["tgl_surtug"] = '<center>'.$tgl_surtug.'</center>';
                $row["tgl_akhir_surtug"] = '<center>'.$tgl_akhir_surtug.'</center>';
            }

            $row["name_surtug"] = $penugasan->name_surtug;
            if ($penugasan->no_surat == "") {
                $row["action"] = '<div class="btn-group">
                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-surtug" data-penugasan_id="'.$penugasan->id.'"><i class="fa fa-plus"></i> Tambah Surat Tugas</a>
                            </div>';
            }else{
                $row["action"] = '<div class="btn-group">
                            <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-surtug-edit" data-penugasan_id="'.$penugasan->id.'"><i class="fa fa-pencil"></i> Ubah Surat Tugas</a>
                            </div>';
               // $row["action"] = '';
            }

            $data[] = $row;

        }
      }

      return response()->json($data,200);
    }

    public function getPenugasan(){
        $penugasan_id = $_GET['penugasan_id'];
        $penugasan = DB::table('penugasans as p')
                        ->join('master_perusahaans as per','per.id','=','p.perusahaan_id')
                          ->leftjoin('users as u1','u1.id','=','p.verifikator1')
                          ->leftjoin('users as u2','u2.id','=','p.verifikator2')
                          ->leftjoin('users as u3','u3.id','=','p.verifikator3')
                          ->leftjoin('users as u4','u4.id','=','p.verifikator4')
                          ->leftjoin('users as u5','u5.id','=','p.verifikator5')
                          ->leftjoin('users as uetc','uetc.id','=','p.etc')
                          ->leftjoin('users as upm','upm.id','=','p.pm')
                          ->where('p.id',$penugasan_id)
                          ->select('p.*','per.nama','u1.name as v1','u2.name as v2','u3.name as v3','u4.name as v4','u5.name as v5','uetc.name as uetc','upm.name as upm')
                          ->first();
        $penugasan->tgl_mulai = implode('/', array_reverse(explode("-", $penugasan->tgl_mulai)));
        $penugasan->tgl_akhir = implode('/', array_reverse(explode("-", $penugasan->tgl_akhir)));
        $v = "<ol style='padding-left:-15px'>";
        if ($penugasan->v1 != "") {
            $v .= "<li>".$penugasan->v1."</li>";
        }
        if ($penugasan->v2 != "") {
            $v .= "<li>".$penugasan->v2."</li>";
        }
        if ($penugasan->v3 != "") {
            $v .= "<li>".$penugasan->v3."</li>";
        }
        if ($penugasan->v4 != "") {
            $v .= "<li>".$penugasan->v4."</li>";
        }
        if ($penugasan->v5 != "") {
            $v .= "<li>".$penugasan->v5."</li>";
        }
        $v .= "</ol>";
        $penugasan->v1 = $v;
        return json_encode($penugasan);
    }

    public function createSurtug(Request $request){
        $tgl_surtug = implode('-', array_reverse(explode("/", $request->tgl_surtug)));
        $tgl_akhir_surtug = implode('-', array_reverse(explode("/", $request->tgl_akhir_surtug)));
        $dataSurtug = array('penugasan_id' => $request->penugasan_id,
                            'no_surat' => $request->no_surat,
                            'tgl_surtug' => $tgl_surtug,
                            'tgl_akhir_surtug' => $tgl_akhir_surtug,
                          );
        $surat_tugas_id = DB::table('surat_tugas')->insertGetId($dataSurtug);
        foreach ($request->verifikator as $key => $value) {
            DB::table('surat_tugas_details')->insert([
                                            'surat_tugas_id'=>$surat_tugas_id,
                                            'user_id'=>$value,
                                            ]);
        }

        Session::flash('success','Surat Tugas Berhasil Dibuat!');
        return redirect('surtug');
    }

    public function updateSurtug(Request $request){
        $tgl_surtug = implode('-', array_reverse(explode("/", $request->tgl_surtug)));
        $tgl_akhir_surtug = implode('-', array_reverse(explode("/", $request->tgl_akhir_surtug)));

        DB::table('surat_tugas')
        ->where('penugasan_id','=', $request->penugasan_id)
        ->update([
                'no_surat' => $request->no_surat,
                'tgl_surtug' => $tgl_surtug,
                'tgl_akhir_surtug' => $tgl_akhir_surtug
            ]
        );

        $surat_tugas = DB::table('surat_tugas as p')
            ->where('p.penugasan_id',$request->penugasan_id)
            ->select('p.*')
            ->first();

        DB::table('surat_tugas_details')->where('surat_tugas_id','=',$surat_tugas->id)->delete();
        foreach ($request->verifikator as $key => $value) {
            DB::table('surat_tugas_details')->insert([
                                            'surat_tugas_id'=>$surat_tugas->id,
                                            'user_id'=>$value,
                                            ]);
        }

        Session::flash('success','Surat Tugas Berhasil Diubah!');
        return redirect('surtug');
    }


    public function getSuratTugas(){
        $penugasan_id = $_GET['penugasan_id'];
        $surat_tugas = DB::table('surat_tugas as p')
            ->where('p.penugasan_id',$penugasan_id)
            ->select('p.*')
            ->first();
        $surat_tugas_details = DB::table('surat_tugas_details as p')
            ->where('p.surat_tugas_id',$surat_tugas->id)
            ->select('p.*')
            ->get();
        $surat_tugas->tgl_surtug = implode('/', array_reverse(explode("-", $surat_tugas->tgl_surtug)));
        $surat_tugas->tgl_akhir_surtug = implode('/', array_reverse(explode("-", $surat_tugas->tgl_akhir_surtug)));
        $surat_tugas->detail = $surat_tugas_details;
        return json_encode($surat_tugas);
    }
}
