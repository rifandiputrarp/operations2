<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterBarangJasa;
use Illuminate\Http\Request;
use URL;
use DB;
use Auth;

class MasterBarangJasaController extends Controller
{
    public function index(){
        return view('master.master-barang-jasa.index');
    }

    public function tambah(){
        return view('master.master-barang-jasa.tambah');
    }

    public function post(Request $req){
        $p = new MasterBarangJasa;
        $p->nama = $req->nama;
        $p->save();
        return redirect('master-barang-jasa')->with('status', 'Data berhasil ditambahkan!');;
    }

    public function edit(Request $req,$id){
      $data = DB::table('master_barang_jasa')->where('id','=',$id)->get();
      return view('master.master-barang-jasa.edit')->with(compact('data'));
    }

    public function getList(){
        $role = Auth::user()->roles->pluck('name');
        $data = [];
        $query = MasterBarangJasa::all();
        for($i=0;$i<count($query);$i++){
          $row["no"] = ($i+1);
          $row["id"] = $query[$i]['id'];
          $row["nama"] = $query[$i]['nama'];
          $button= ' <div class="btn-group">';
          if ($role[0] == "Admin" || $role[0] == "PM") {
          $button .= '
                    <a href="'.URL::to('master-barang-jasa/edit/'.$query[$i]->id).'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i>Edit</a>
                    <a href="#" onclick="klikDelete(formdel'.$query[$i]->id.')" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>Delete
                        </a>
                        <form id="formdel' . $query[$i]->id . '" method="POST" action="' . URL::to('master-barang-jasa/delete/'.$query[$i]->id).'">
                            '.csrf_field().'
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </div>
                          ';
          }
          $button .= '</div>';
          $row["action"] = $button;
          $data[] = $row;
  
        }
        return response()->json($data,200);
      }

      public function update(Request $req,$id){
        $update = DB::table('master_barang_jasa')
          ->where('id','=',$id)
          ->update([
              'nama' => $req->nama
            ]
          );
        return redirect('master-barang-jasa')->with('status', 'Data successfully added!');;
      }

      public function delete($id){
        $oc = MasterBarangJasa::Find($id)->delete();
        return redirect('master-barang-jasa')->with('status', 'Data berhasil dihapus!');;
    }


}
