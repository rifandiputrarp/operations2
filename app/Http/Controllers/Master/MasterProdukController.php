<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterProduk;

class MasterProdukController extends Controller
{
    public function index(){
        return view('master.master-produk.index');
    }

    public function tambah(){
        return view('master.master-produk.tambah');
    }

    public function post(Request $req){
        $p = new MasterProduk;
        $p->nama_produk = $req->nama;
        $p->kode_permen = $req->kode_permen;
        $p->save();
        return redirect('master-produk')->with('status', 'Data berhasil ditambahkan!');;
    }

    public function getList(){
        $data = [];
        $query = MasterProduk::all();
        for($i=0;$i<count($query);$i++){
          $row["no"] = ($i+1);
          $row["id"] = $query[$i]['id'];
          $row["nama_produk"] = $query[$i]['nama_produk'];
          $row["kode_permen"] = $query[$i]['kode_permen'];
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
