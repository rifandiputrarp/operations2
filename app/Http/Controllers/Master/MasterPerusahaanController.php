<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use File;
use App\Models\MasterPerusahaan;
use App\Models\MasterPerusahaanAlamat;
use URL;
use Response;
use Auth;
use Svg\Tag\Rect;

class MasterPerusahaanController extends Controller
{
  public function index()
  {
    return view('master.master-perusahaan.index');
  }

  public function tambah($data = null)
  {
    $provinsi = DB::table('tbl_provinsi')->get();
    $badan = DB::table('master_badans')->get();
    return view('master.master-perusahaan.tambah')->with(compact('provinsi', 'data', 'badan'));
  }

  public function post(Request $req)
  {
    $tanggal_akta = implode("-", array_reverse(explode("/", $req->tanggal_akta)));
    $tanggal_terbit_ijin = implode("-", array_reverse(explode("/", $req->tanggal_terbit_ijin)));
    $kode = $req->kode;
    $p = new MasterPerusahaan;
    $p->badan = strtoupper($req->badan);
    $p->nama = strtoupper($req->nama);
    // ALAMAT PUSAT
    /*$p->alamat_pusat = $req->alamat_pusat;
      if ($req->kode_provinsi != "") {
        $p->kode_provinsi_pusat = $req->kode_provinsi;
        $getkode = DB::table('tbl_provinsi')->where('kode_provinsi',$req->kode_provinsi)->get();
        $p->provinsi_pusat = $getkode[0]->provinsi;
      }
      if ($req->kode_kabupaten != "") {
        $p->kode_kabupaten_pusat = $req->kode_kabupaten;
        $getkode = DB::table('tbl_kota_kab')->where('kode_kota_kab',$req->kode_kabupaten)->get();
        $p->kabupaten_pusat = $getkode[0]->kota;
      }
      if ($req->kode_kec != "") {
        $p->kode_kecamatan_pusat = $req->kode_kec;
        $getkode = DB::table('tbl_kecamatan')->where('kode_kec',$req->kode_kec)->get();
        $p->kecamatan_pusat = $getkode[0]->kecamatan;
      }
      if ($req->kode_kel != "") {
        $p->kode_kelurahan_pusat = $req->kode_kel;
        $getkode = DB::table('tbl_kelurahan')->where('kode_desa',$req->kode_kel)->get();
        $p->kelurahan_pusat = $getkode[0]->desa_kelurahan;
      }
      $p->email_pusat = $req->email_pusat;
      $p->kode_pos_pusat = $req->kode_pos;
      $p->telepon_pusat = $req->telepon;
      $p->fax_pusat = $req->fax;

      // ALAMAT PABRIK
      $p->alamat_pabrik = $req->alamat_pabrik;
      if ($req->kode_provinsi2 != "") {
        $p->kode_provinsi_pabrik = $req->kode_provinsi2;
        $getkode = DB::table('tbl_provinsi')->where('kode_provinsi',$req->kode_provinsi2)->get();
        $p->provinsi_pabrik = $getkode[0]->provinsi;
      }
      if ($req->kode_kabupaten2 != "") {
        $p->kode_kabupaten_pabrik = $req->kode_kabupaten2;
        $getkode = DB::table('tbl_kota_kab')->where('kode_kota_kab',$req->kode_kabupaten2)->get();
        $p->kabupaten_pabrik = $getkode[0]->kota;
      }
      if ($req->kode_kec2 != "") {
        $p->kode_kecamatan_pabrik = $req->kode_kec2;
        $getkode = DB::table('tbl_kecamatan')->where('kode_kec',$req->kode_kec2)->get();
        $p->kecamatan_pabrik = $getkode[0]->kecamatan;
      }
      if ($req->kode_kel2 != "") {
        $p->kode_kelurahan_pabrik = $req->kode_kel2;
        $getkode = DB::table('tbl_kelurahan')->where('kode_desa',$req->kode_kel2)->get();
        $p->kelurahan_pabrik = $getkode[0]->desa_kelurahan;
      }
      $p->email_pabrik = $req->email_pabrik;
      $p->kode_pos_pabrik = $req->kode_pos2;
      $p->telepon_pabrik = $req->telepon2;
      $p->fax_pabrik = $req->fax2;*/

    $p->status = $req->status;
    $p->pejabat = $req->pejabat;
    $p->jabatan = $req->jabatan;
    $p->akta_pendirian = $req->akta;
    $p->tanggal_akta = $tanggal_akta;
    $p->npwp = $req->npwp;
    $p->ijin_usaha = $req->ijin_usaha;
    $p->penerbit_ijin = $req->penerbit_ijin;
    $p->tanggal_terbit_ijin = $tanggal_terbit_ijin;
    $p->notaris = $req->notaris;
    $p->nib = $req->nib;
    $p->saham_negeri = $req->saham_negeri;
    $p->saham_luar_negeri = $req->saham_luar_negeri;
    $p->save();

    if ($kode <> null) {
      $url = 'konfirmasi-order/tambah';
    } else {
      $url = 'master-perusahaan';
    }

    return redirect($url)->with('status', 'Data berhasil ditambahkan!');;
  }

  public function getList()
  {
    $role = Auth::user()->roles->pluck('name');

    $data = [];
    $query = MasterPerusahaan::all();

    for ($i = 0; $i < count($query); $i++) {
      $id = $query[$i]['id'];
      $alamats = DB::table('master_perusahaan_alamat')->where('id_perusahaan', '=', $id)->get();
      $pusat_address = "";
      $pabrik_address = "";
      foreach ($alamats as $alamat) {
        if ($alamat->jenis_kantor == 1) {
          $pusat_address = $pusat_address . $alamat->alamat . "<br> ";
        } else if ($alamat->jenis_kantor == 2) {
          $pabrik_address = $pabrik_address . $alamat->alamat . "<br> ";
        }
      }

      $row["no"] = ($i + 1);
      $row["id"] = $query[$i]['id'];
      $row["nama"] = $query[$i]['badan'] . ' ' . $query[$i]['nama'];
      $row["alamat_pusat"] = $pusat_address; //$query[$i]['alamat_pusat'];
      $row["alamat_pabrik"] = $pabrik_address; //$query[$i]['alamat_pabrik'];
      $button = ' <div class="btn-group">
                    <a href="' . URL::to('master-perusahaan/edit/' . $query[$i]->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                    <a href="' . URL::to('master-perusahaan/alamat/' . $query[$i]->id) . '" class="btn btn-sm btn-success"><i class="fa fa-map-marked-alt"></i> Alamat</a>
                    <a href="' . URL::to('master-perusahaan/file/' . $query[$i]->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-file"></i> File</a>
                    <a href="' . URL::to('master-perusahaan/standar/' . $query[$i]->id) . '" class="btn btn-sm btn-info"><i class="fa fa-clipboard-list"></i> Standar</a>';

      $button .= '</div>';
      if ($role[0] == "Admin" || $role[0] == "PM") {
        $button .= '
              <a href="#" onclick="klikDelete(formdel' . $query[$i]->id . ')" class="btn btn-sm btn-danger float-right">
                  <i class="fa fa-trash"></i> Delete
              </a>
              <form id="formdel' . $query[$i]->id . '" method="POST" action="' . URL::to('master-perusahaan/delete/' . $query[$i]->id) . '">
                  ' . csrf_field() . '
                  <input type="hidden" name="_method" value="DELETE">
              </form>';
      }
      $row["action"] = $button;
      $data[] = $row;
    }
    return response()->json($data, 200);
  }

  public function getKab($id)
  {
    $kab = substr($id, 0, 2);

    $regs = DB::table('tbl_kota_kab')->where('kode_kota_kab', 'LIKE', $kab . '__00');
    if (isset($_GET['search'])) {
      $regs = DB::table('tbl_kota_kab')->where('kode_kota_kab', 'LIKE', $kab . '__00')->where('kota', 'LIKE', '%' . $_GET['search'] . '%');
    }
    return response()->json($regs->get(), 200);
  }

  public function getKec($id)
  {
    $regs = DB::table('tbl_kecamatan')->where('kode_kota_kab', '=', $id);
    if (isset($_GET['search'])) {
      $regs = DB::table('tbl_kecamatan')->where('kode_kota_kab', '=', $id)->where('kecamatan', 'LIKE', '%' . $_GET['search'] . '%');
    }
    return response()->json($regs->get(), 200);
  }

  public function getKel($id)
  {
    $regs = DB::table('tbl_kelurahan')->where('kode_kecamatan', '=', $id);
    if (isset($_GET['search'])) {
      $regs = DB::table('tbl_kelurahan')->where('kode_kecamatan', '=', $id)->where('desa_kelurahan', 'LIKE', '%' . $_GET['search'] . '%');
    }
    return response()->json($regs->get(), 200);
  }

  public function delete($id)
  {
    $del = MasterPerusahaan::Find($id)->delete();
    return redirect('master-perusahaan')->with('status', 'Data berhasil dihapus!');;
  }

  public function edit($id)
  {
    $data = DB::table('master_perusahaans')->where('id', '=', $id)->get();
    $badan = DB::table('master_badans')->get();
    $provinsi = DB::table('tbl_provinsi')->get();
    $kabupaten_pusat = DB::table('tbl_kota_kab')->where('kode_provinsi', $data[0]->kode_provinsi_pusat)->get();
    $kabupaten_pabrik = DB::table('tbl_kota_kab')->where('kode_provinsi', $data[0]->kode_provinsi_pabrik)->get();
    return view('master.master-perusahaan.edit')->with(compact('data', 'id', 'badan', 'provinsi', 'kabupaten_pusat', 'kabupaten_pabrik'));
  }

  public function alamat($id)
  {
    $data_perusahaan = DB::table('master_perusahaans')->where('id', '=', $id)->get();
    $data = DB::table('master_perusahaan_alamat')->where('id_perusahaan', '=', $id)->get();

    $badan = DB::table('master_badans')->get();
    $provinsi = DB::table('tbl_provinsi')->get();
    $kabupaten = DB::table('tbl_kota_kab')->where('kode_provinsi', $data_perusahaan[0]->kode_provinsi_pusat)->get();
    $kabupaten_pabrik = DB::table('tbl_kota_kab')->where('kode_provinsi', $data_perusahaan[0]->kode_provinsi_pabrik)->get();
    return view('master.master-perusahaan.alamat')->with(compact('data_perusahaan', 'data', 'id', 'badan', 'provinsi', 'kabupaten', 'kabupaten_pabrik'));
  }

  public function file($id)
  {

    $data_perusahaan = DB::table('master_perusahaans')->where('id', '=', $id)->get();
    $data = DB::table('master_perusahaan_file')->where('id_perusahaan', '=', $id)->get();
    return view('master.master-perusahaan.file')->with(compact('data_perusahaan', 'data', 'id'));
  }

  public function getFile()
  {
    $id = $_GET['id_perusahaan'];
    $data['data'] = array();
    $query = DB::table('master_perusahaan_file')->where('id_perusahaan', '=', $id)->get();

    for ($i = 0; $i < count($query); $i++) {
      $row["no"] = ($i + 1);
      $row["id"] = $query[$i]->id;
      $row["nama_file"] = '<a href="' . URL::to('master-perusahaan/downloadFile/' . $query[$i]->id) . '">' . $query[$i]->nama_file_asli . '</a>';
      $row["keterangan"] = $query[$i]->keterangan;
      $row["action"] = '<div class="btn-group-vertical ">
                                <a href="#" onclick="klikDelete(formdel' . $query[$i]->id . ')" class="btn btn-sm btn-outline-danger text-left">
                                    <i class="fa fa-trash"></i>&nbsp; Delete
                                </a>
                                <form id="formdel' . $query[$i]->id . '" method="POST" action="' . URL::to('master-perusahaan/deleteFile/' . $query[$i]->id) . '">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                </div>';
      $data['data'][] = $row;
    }
    return response()->json($data, 200);
  }

  public function uploadFile(Request $request)
  {
    $now = date("Y-m-d H:i:s");
    $id_perusahaan = $request->id_perusahaan;
    $keterangan = $request->keterangan;

    $nama_file_asli = $request->file->getClientOriginalName();
    $nama_file = time() . '.' . $request->file->extension();

    $path = storage_path('app/public/file/');
    $request->file->move($path, $nama_file);
    $inputFileName = $path . $nama_file;

    DB::beginTransaction();
    try {
      $dataSave = array(
        'nama_file_asli' => $nama_file_asli,
        'nama_file' => $nama_file,
        'path' => $path,
        'keterangan' => $keterangan,
        'id_perusahaan' => $id_perusahaan,
      );
      $dataSave['created_at'] = $now;
      DB::table('master_perusahaan_file')->insert($dataSave);
      DB::commit();
      $url = 'master-perusahaan/file/' . $id_perusahaan;
      return redirect($url)->with('status', 'Data berhasil Disimpan');;
    } catch (\Exception $e) {
      DB::rollback();
      echo "Upload Gagal $e";
      die;
    }
  }

  public function downloadFile($file_id)
  {
    $verProdFile = DB::table('master_perusahaan_file')->find($file_id);
    $file = $verProdFile->path . $verProdFile->nama_file;
    return Response::download($file, $verProdFile->nama_file_asli);
  }

  public function deleteFile($id)
  {
    $verProduk = DB::table('master_perusahaan_file as f')
      ->where('f.id', '=', $id)
      ->first();
    $id_perusahaan = $verProduk->id_perusahaan;
    $file = $verProduk->path . $verProduk->nama_file;

    DB::table('master_perusahaan_file')->where('id', '=', $id)->delete();
    File::delete($file);

    $url = 'master-perusahaan/file/' . $id_perusahaan;
    return redirect($url)->with('status', 'Data berhasil Dihapus');;
  }

  public function update(Request $req, $id)
  {
    $tanggal_akta = implode("-", array_reverse(explode("/", $req->tanggal_akta)));
    $tanggal_terbit_ijin = implode("-", array_reverse(explode("/", $req->tanggal_terbit_ijin)));
    $p = MasterPerusahaan::find($id);
    $p->badan = $req->badan;
    $p->nama = strtoupper($req->nama);
    /*  // ALAMAT PUSAT
      $p->alamat_pusat = $req->alamat_pusat;
      if ($req->kode_provinsi != "") {
        $p->kode_provinsi_pusat = $req->kode_provinsi;
        $getkode = DB::table('tbl_provinsi')->where('kode_provinsi',$req->kode_provinsi)->get();
        $p->provinsi_pusat = $getkode[0]->provinsi;
      }
      if ($req->kode_kabupaten != "") {
        $p->kode_kabupaten_pusat = $req->kode_kabupaten;
        $getkode = DB::table('tbl_kota_kab')->where('kode_kota_kab',$req->kode_kabupaten)->get();
        $p->kabupaten_pusat = $getkode[0]->kota;
      }
      if ($req->kode_kec != "") {
        $p->kode_kecamatan_pusat = $req->kode_kec;
        $getkode = DB::table('tbl_kecamatan')->where('kode_kec',$req->kode_kec)->get();
        $p->kecamatan_pusat = $getkode[0]->kecamatan;
      }
      if ($req->kode_kel != "") {
        $p->kode_kelurahan_pusat = $req->kode_kel;
        $getkode = DB::table('tbl_kelurahan')->where('kode_desa',$req->kode_kel)->get();
        $p->kelurahan_pusat = $getkode[0]->desa_kelurahan;
      }
      $p->email_pusat = $req->email_pusat;
      $p->kode_pos_pusat = $req->kode_pos;
      $p->telepon_pusat = $req->telepon;
      $p->fax_pusat = $req->fax;

      // ALAMAT PABRIK
      $p->alamat_pabrik = $req->alamat_pabrik;
      if ($req->kode_provinsi2 != "") {
        $p->kode_provinsi_pabrik = $req->kode_provinsi2;
        $getkode = DB::table('tbl_provinsi')->where('kode_provinsi',$req->kode_provinsi2)->get();
        $p->provinsi_pabrik = $getkode[0]->provinsi;
      }
      if ($req->kode_kabupaten2 != "") {
        $p->kode_kabupaten_pabrik = $req->kode_kabupaten2;
        $getkode = DB::table('tbl_kota_kab')->where('kode_kota_kab',$req->kode_kabupaten2)->get();
        $p->kabupaten_pabrik = $getkode[0]->kota;
      }
      if ($req->kode_kec2 != "") {
        $p->kode_kecamatan_pabrik = $req->kode_kec2;
        $getkode = DB::table('tbl_kecamatan')->where('kode_kec',$req->kode_kec2)->get();
        $p->kecamatan_pabrik = $getkode[0]->kecamatan;
      }
      if ($req->kode_kel2 != "") {
        $p->kode_kelurahan_pabrik = $req->kode_kel2;
        $getkode = DB::table('tbl_kelurahan')->where('kode_desa',$req->kode_kel2)->get();
        $p->kelurahan_pabrik = $getkode[0]->desa_kelurahan;
      }
      $p->email_pabrik = $req->email_pabrik;
      $p->kode_pos_pabrik = $req->kode_pos2;
      $p->telepon_pabrik = $req->telepon2;
      $p->fax_pabrik = $req->fax2;*/

    $p->status = $req->status;
    $p->pejabat = $req->pejabat;
    $p->jabatan = $req->jabatan;
    $p->akta_pendirian = $req->akta;
    $p->tanggal_akta = $tanggal_akta;
    $p->npwp = $req->npwp;
    $p->ijin_usaha = $req->ijin_usaha;
    $p->penerbit_ijin = $req->penerbit_ijin;
    $p->tanggal_terbit_ijin = $tanggal_terbit_ijin;
    $p->notaris = $req->notaris;
    $p->nib = $req->nib;
    $p->saham_negeri = $req->saham_negeri;
    $p->saham_luar_negeri = $req->saham_luar_negeri;
    $p->save();

    return redirect('master-perusahaan')->with('status', 'Data successfully added!');;
  }

  public function update_alamat(Request $req, $id)
  {
    DB::table('master_perusahaan_alamat')->where('id_perusahaan', '=', $id)->delete();
    if (isset($req->jenis_kantor)) {
      for ($i = 0; $i < count($req->jenis_kantor); $i++) {
        $p = new MasterPerusahaanAlamat;
        $p->id_perusahaan = $id;
        $p->jenis_kantor = $req->jenis_kantor[$i];
        $p->alamat = $req->alamat[$i];
        if ($req->kode_provinsi[$i] != "") {
          $p->kode_provinsi = $req->kode_provinsi[$i];
          $getkode = DB::table('tbl_provinsi')->where('kode_provinsi', $req->kode_provinsi[$i])->get();
          $p->provinsi = $getkode[0]->provinsi;
        }
        if ($req->kode_kabupaten[$i] != "") {
          $p->kode_kabupaten = $req->kode_kabupaten[$i];
          $getkode = DB::table('tbl_kota_kab')->where('kode_kota_kab', $req->kode_kabupaten[$i])->get();
          $p->kabupaten = $getkode[0]->kota;
        }
        if ($req->kode_kec[$i] != "") {
          $p->kode_kecamatan = $req->kode_kec[$i];
          $getkode = DB::table('tbl_kecamatan')->where('kode_kec', $req->kode_kec[$i])->get();
          $p->kecamatan = $getkode[0]->kecamatan;
        }
        if ($req->kode_kel[$i] != "") {
          $p->kode_kelurahan = $req->kode_kel[$i];
          $getkode = DB::table('tbl_kelurahan')->where('kode_desa', $req->kode_kel[$i])->get();
          $p->kelurahan = $getkode[0]->desa_kelurahan;
        }
        $p->email = $req->email[$i];
        $p->kode_pos = $req->kode_pos[$i];
        $p->telepon = $req->telepon[$i];
        $p->fax = $req->fax[$i];

        $p->save();
      }
    }




    $url = 'master-perusahaan';
    return redirect($url)->with('status', 'Data berhasil ditambahkan!');;
  }

  public function standar($id)
  {
    $getStandar = DB::table('master_perusahaan_standars')->where('perusahaan_id', $id)->get();

    return view('master/master-perusahaan/standar')->with(compact('getStandar', 'id'));
  }

  public function simpanStandar(Request $request)
  {
    DB::beginTransaction();
    try {
      $jenis_standar = $request->jenis_standar;
      $no_sertifikat = $request->no_sertifikat;
      $tanggal = $request->tanggal;
      $badan_sertifikat = $request->badan_sertifikat;

      DB::table('master_perusahaan_standars')->where('perusahaan_id', $request->perusahaan_id)->delete();
      for ($i = 0; $i < count($request->jenis_standar); $i++) {
        $dataInsert = array(
          'perusahaan_id' => $request->perusahaan_id,
          'jenis_standar' => $jenis_standar[$i],
          'no_sertifikat' => $no_sertifikat[$i],
          'tanggal' => implode("-", array_reverse(explode("/", $tanggal[$i]))),
          'badan_sertifikat' => $badan_sertifikat[$i],
        );
        DB::table('master_perusahaan_standars')->insert($dataInsert);
      }
      DB::commit();
      return redirect('master-perusahaan/standar/' . $request->perusahaan_id)->with('status', 'Data berhasil ditambahkan!');;
    } catch (\Exception $e) {
      DB::rollback();
      return redirect('master-perusahaan/standar/' . $request->perusahaan_id)->with('error', 'Terjadi Kesalahan! Mohon Diulang Kembali.');;
    }
  }
}
