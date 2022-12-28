<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use URL;
use Auth;
use App\Models\KonfirmasiOrder;
use App\Models\KonfirmasiOrderProduk;

class PerusahaanController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        return view('perusahaan.index');
    }

    public function tambah(){
        $perusahaan = DB::table('master_perusahaans')->get();
        $kelompok = DB::table('master_barang_jasa')->get();
        return view('perusahaan.tambah')->with(compact('perusahaan','kelompok'));
    }

    public function save(Request $request){
        return redirect('perusahaan/daftar');
    }

    public function getList(){
        $role = Auth::user()->roles->pluck('name');
        $data = [];
        $query = DB::table('konfirmasi_orders as ko')
                    ->join('master_perusahaans as mp','mp.id','=','ko.id_perusahaan_diverifikasi')
                    ->select(array('ko.id','ko.nomor','ko.objek_order','mp.nama', 'ko.status'))
                    ->get();

        for($i=0;$i<count($query);$i++){
          $row["no"] = ($i+1);
          $row["id"] = $query[$i]->id;
          $row["nama"] = $query[$i]->nama;
          $row["objek_order"] = $query[$i]->objek_order;

          $status = $query[$i]->status;
        
          if( ($role[0] === 'Marketing' || $role[0] === 'Admin') && $status == 0){
            $row["status"] = '<span class="badge badge-warning">Waiting Approval</span>';
            $row["action"] = '<div class="btn-group">
                                <a href="#" class="btn btn-sm btn-info"><i class="fa fa-list"></i></a>
                                <a href="'.URL::to('konfirmasi-order/edit/'.$query[$i]->id).'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                            </div>';
          }else if ($role[0] === 'Marketing' && $status == 1){
            $row["status"] = '<span class="badge badge-success">Approved</span>';
            $row["action"] = '<div class="btn-group">
                                <a href="#" class="btn btn-sm btn-info"><i class="fa fa-list"></i></a>
                            </div>';
          }else{
            $row["status"] = '<span class="badge badge-success">Approved</span>';
            $row["action"] = '<div class="btn-group">
                                <a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Approve</a>
                            </div>';
          }

          $data[] = $row;
  
        }
        return response()->json($data,200);
    }

    public function edit($id){
        $dataPerusahaan = KonfirmasiOrder::find($id);
        $produk = DB::table('konfirmasi_order_produks')->where('oc_id','=',$id)->get();
        $perusahaan = DB::table('master_perusahaans')->get();
        $kelompok = DB::table('master_barang_jasa')->get();
        return view('perusahaan.edit')->with(compact('produk','dataPerusahaan','kelompok','perusahaan'));
    }
}
