<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBidangUsaha;

class MasterBidangUsahaController extends Controller
{
    public function index(){
        return view('master.master-bidang-usaha.index');
    }

    public function tambah(){
        return view('master.master-bidang-usaha.tambah');
    }

    public function post(Request $req){
        $p = new MasterBidangUsaha;
        $p->nama = $req->nama;
        $p->save();
        return redirect('master-bidang-usaha')->with('status', 'Data berhasil ditambahkan!');;
    }

    public function getList(){
        $data = [];
        $query = MasterBidangUsaha::all();
        for($i=0;$i<count($query);$i++){
          $row["no"] = ($i+1);
          $row["id"] = $query[$i]['id'];
          $row["nama"] = $query[$i]['nama'];
          $row["action"] = ' <div class="btn-group">
                            <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                            </div>
                          ';
          $data[] = $row;
  
        }
        return response()->json($data,200);
      }
}
