<?php

namespace App\Http\Controllers\Permen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;

class PermenController extends Controller
{
    public function index(){
        $masterPermen = DB::table('master_permens')->get();
        return view('permen.index',compact('masterPermen'));
    }

    public function getDataEdit(){
        $id = $_GET['id'];
        $permen = DB::table('master_permens')->find($id);
        return json_encode($permen);
    }

    public function editDasarHukum(Request $request){
        DB::table('master_permens')->where('id',$request->permen_id)->update(['dasar_hukum'=>$request->dasar_hukum]);
        Session::flash('success','Dasar Hukum Berhasil Diubah!');
        return redirect('permenperin');
    }

    public function download($id){
        $file_name = '';
        if($id === '22'){
            $file_name = 'PERMENPERIN No. 22 Th 2020.xlsx';
        }
        $file_path = public_path('template/'.$file_name);
        return response()->download($file_path);
    }

    public function unggah(Request $request){
        $file = $request->file('file');
        $namefile = $file->getClientOriginalName();
        $destinationPath = public_path('lampiran/');
        $file->move($destinationPath,$namefile);

        $path = public_path('lampiran/'.$namefile);
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        dd($spreadsheet);
    }
}
