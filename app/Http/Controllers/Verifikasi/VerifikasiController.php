<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Response;
use URL;
use Auth;
use Session;

class VerifikasiController extends Controller
{
    public function getAlamat()
    {
        $perusahaan_id = $_GET['perusahaan_id'];
        $alamat_id = $_GET['alamat_id'];
        $tipe_alamat = $_GET['tipe_alamat'];
        $getAlamat = DB::table('master_perusahaan_alamat as a')
            ->where('id_perusahaan', $perusahaan_id)
            ->where('a.jenis_kantor', 2)
            ->select('a.id', 'alamat', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi')
            ->get();
        $row = array();
        foreach ($getAlamat as $val) {
            $temp['id'] = $val->id;
            $temp['alamat'] = $val->alamat . ", " . $val->kelurahan . ", " . $val->kecamatan . ", " . $val->kabupaten . ", " . $val->provinsi;
            $row[] = $temp;
        }

        echo json_encode($row);
    }

    public function simpan_alamat(Request $request)
    {
        $penugasan_id = $request->penugas_id;
        $tipe_alamat = $request->tipe_alamat;
        $alamat_id = $request->alamat;

        DB::table('penugasans')->where('id', $penugasan_id)->update([$tipe_alamat => $alamat_id]);

        return redirect('verifikasi/mulai/' . $penugasan_id);
    }

    public function migrate()
    {
        $per = DB::table('master_perusahaans')->get();
        for ($i = 0; $i < count($per); $i++) {
            if ($per[$i]->provinsi_pusat != "" && $per[$i]->kode_provinsi_pusat != "") {
                $insertPusat = array(
                    'id_perusahaan' => $per[$i]->id,
                    'jenis_kantor' => 1,
                    'alamat' => $per[$i]->alamat_pusat,
                    'provinsi' => $per[$i]->provinsi_pusat,
                    'kode_provinsi' => $per[$i]->kode_provinsi_pusat,
                    'kabupaten' => $per[$i]->kabupaten_pusat,
                    'kode_kabupaten' => $per[$i]->kode_kabupaten_pusat,
                    'kecamatan' => $per[$i]->kecamatan_pusat,
                    'kode_kecamatan' => $per[$i]->kode_kecamatan_pusat,
                    'kelurahan' => $per[$i]->kelurahan_pusat,
                    'kode_kelurahan' => $per[$i]->kode_kelurahan_pusat,
                    'email' => $per[$i]->email_pusat,
                    'telepon' => $per[$i]->telepon_pusat,
                    'fax' => $per[$i]->fax_pusat,
                    'kode_pos' => $per[$i]->kode_pos_pusat,
                );
                DB::table('master_perusahaan_alamat')->insert($insertPusat);
            }
            if ($per[$i]->provinsi_pabrik != "" && $per[$i]->kode_provinsi_pabrik != "") {
                $insertPabrik = array(
                    'id_perusahaan' => $per[$i]->id,
                    'jenis_kantor' => 2,
                    'alamat' => $per[$i]->alamat_pabrik,
                    'provinsi' => $per[$i]->provinsi_pabrik,
                    'kode_provinsi' => $per[$i]->kode_provinsi_pabrik,
                    'kabupaten' => $per[$i]->kabupaten_pabrik,
                    'kode_kabupaten' => $per[$i]->kode_kabupaten_pabrik,
                    'kecamatan' => $per[$i]->kecamatan_pabrik,
                    'kode_kecamatan' => $per[$i]->kode_kecamatan_pabrik,
                    'kelurahan' => $per[$i]->kelurahan_pabrik,
                    'kode_kelurahan' => $per[$i]->kode_kelurahan_pabrik,
                    'email' => $per[$i]->email_pabrik,
                    'telepon' => $per[$i]->telepon_pabrik,
                    'fax' => $per[$i]->fax_pabrik,
                    'kode_pos' => $per[$i]->kode_pos_pabrik,
                );
                DB::table('master_perusahaan_alamat')->insert($insertPabrik);
                $alamat_id = DB::getPdo()->lastInsertId();
                DB::table('penugasans')->where('perusahaan_id', $per[$i]->id)->update(['alamat_id' => $alamat_id]);
                DB::table('penugasans')->where('perusahaan_lokal_id', $per[$i]->id)->update(['alamat_lokal_id' => $alamat_id]);
                DB::table('penugasans')->where('perusahaan_pengembang_id', $per[$i]->id)->update(['alamat_pengembang_id' => $alamat_id]);
            }
        }
        echo 'done';
    }

    public function index()
    {
        $permen = DB::table('master_permens as p')->get();
        return view('verifikasi.index', compact('permen'));
    }

    public function getDataSurtug()
    {
        $role = Auth::user()->roles->pluck('name');
        $whereRaw = "1";
        if ($role[0] == "Verifikator" || $role[0] == "ETC") {
            $whereRaw .= " and (p.verifikator1 = " . Auth::user()->id;
            $whereRaw .= " or p.verifikator2 = " . Auth::user()->id;
            $whereRaw .= " or p.verifikator3 = " . Auth::user()->id;
            $whereRaw .= " or p.verifikator4 = " . Auth::user()->id;
            $whereRaw .= " or p.verifikator5 = " . Auth::user()->id;
            $whereRaw .= " or p.etc = " . Auth::user()->id . ")";
        }
        $data = [];
        $penugas = DB::table('penugasans as p')
            ->join('master_perusahaans as per', 'p.perusahaan_id', '=', 'per.id')
            ->leftjoin('master_permens as mp', 'mp.id', '=', 'p.permen_id')
            ->leftjoin('users as u1', 'u1.id', '=', 'p.verifikator1')
            ->leftjoin('users as u2', 'u2.id', '=', 'p.verifikator2')
            ->leftjoin('users as u3', 'u3.id', '=', 'p.verifikator3')
            ->leftjoin('users as u4', 'u4.id', '=', 'p.verifikator4')
            ->leftjoin('users as u5', 'u5.id', '=', 'p.verifikator5')
            ->leftjoin('users as uetc', 'uetc.id', '=', 'p.etc')
            ->whereRaw($whereRaw)
            ->groupBy('p.id')
            ->orderBy('p.id', 'DESC')
            ->select(array('p.id', 'p.no_ref', 'mp.nama_permen', 'p.tgl_mulai', 'p.tgl_akhir', 'p.jml_produk', 'u1.name as v1', 'u2.name as v2', 'u3.name as v3', 'u4.name as v4', 'u5.name as v5', 'uetc.name as uetc', DB::raw('CONCAT(COALESCE(per.badan,"")," ",per.nama,"<small>(",COALESCE(per.alamat_pabrik,""),")</small>") as nama_perusahaan')))
            ->get();

        if (count($penugas) > 0) {
            $ver = '<ol style="padding-left:20px">';
            $e = $ver;
            foreach ($penugas as $idx => $penugas) {
                $tgl_mulai = implode("/", array_reverse(explode("-", $penugas->tgl_mulai)));
                $tgl_akhir = implode("/", array_reverse(explode("-", $penugas->tgl_akhir)));
                $row["no"] = '<center>' . ($idx + 1) . '</center>';
                $row["id"] = $penugas->id;
                $row["no_ref"] = $penugas->no_ref;
                if ($penugas->nama_permen == "") {
                    $row["nama_perusahaan"] = '<a href="#" onclick="alertPermen()">' . $penugas->nama_perusahaan . '</a>';
                    $nama_permen = '<center><a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-permen" data-penugas_id="' . $penugas->id . '">Pilih</a></center>';
                } else {
                    $row["nama_perusahaan"] = '<a href="' . URL::to('verifikasi/mulai/' . $penugas->id) . '">' . $penugas->nama_perusahaan . '</a>';
                    $nama_permen = $penugas->nama_permen . ' <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-permen" data-penugas_id="' . $penugas->id . '">Edit</a>';
                }
                $row["nama_permen"] = $nama_permen;
                $row["tgl"] = '<i>Mulai</i> : ' . $tgl_mulai . '<br><i>Akhir</i> : ' . $tgl_akhir;

                // verifikator
                $v = "<i>Verifikator:</i><br><ol style='padding-left:20px'>";
                if ($penugas->v1 != "") {
                    $v .= "<li>";
                    $v .= $penugas->v1;
                    $v .= "</li>";
                }
                if ($penugas->v2 != "") {
                    $v .= "<li>";
                    $v .= $penugas->v2;
                    $v .= "</li>";
                }
                if ($penugas->v3 != "") {
                    $v .= "<li>";
                    $v .= $penugas->v3;
                    $v .= "</li>";
                }
                if ($penugas->v4 != "") {
                    $v .= "<li>";
                    $v .= $penugas->v4;
                    $v .= "</li>";
                }
                if ($penugas->v5 != "") {
                    $v .= "<li>";
                    $v .= $penugas->v5;
                    $v .= "</li>";
                }
                $v .= "</ol>";
                // etc
                $v .= "<i>ETC:</i><br><ol style='padding-left:20px'>";
                if ($penugas->uetc != "") {
                    $v .= "<li>";
                    $v .= $penugas->uetc;
                    $v .= "</li>";
                }
                $v .= "</ol>";
                if ($penugas->v1 != "") {
                    $row["verifikator"] = $v;
                } else {
                    $row["verifikator"] = "-";
                }

                $jml_produk = '<i>Total</i> : <b>' . $penugas->jml_produk . '</b><br>';
                $jumlahProduk = DB::table('verifikasi_produks as v')
                    ->join('verifikasi_produk_files as f', 'f.ver_produk_id', '=', 'v.id')
                    ->where('v.penugasan_id', $penugas->id)
                    ->whereNotNull('f.nama_file')
                    ->groupBy('v.penugasan_id')
                    ->get(array(DB::raw('count(v.id) as jumlah')));
                $jml_produk .= '<i>Telah Diverifikasi</i> : <b>' . (int)@$jumlahProduk[0]->jumlah . '</b>';
                $row["jml_produk"] = '<p class="">' . $jml_produk . '</p>';
                $row["action"] = '<div class="btn-group-vertical">
                                <a href="' . URL::to('verifikasi/mulai/' . $penugas->id) . '" class="btn btn-sm btn-success"><i class="fa fa-play"></i></a>
                                <a href="' . URL::to('#') . '" class="btn btn-sm btn-dark"><i class="fa fa-file"></i></a>
                                </div>';

                $data[] = $row;
            }
        }

        return response()->json($data, 200);
    }

    public function simpan_permen(Request $req)
    {
        DB::table('penugasans')->where('id', $req->penugas_id)->update(['permen_id' => $req->permen_id]);
        echo 1;
    }

    public function simpan_perusahaan(Request $req)
    {
        $field = $req->tipe_perusahaan;
        DB::table('penugasans')->where('id', $req->penugas_id)->update([$field => $req->perusahaan_id]);
        return redirect('verifikasi/mulai/' . $req->penugas_id);
    }

    public function mulai($id)
    {
        $penugasan = DB::table('penugasans as pg')
            ->leftJoin('master_permens as p', 'p.id', '=', 'pg.permen_id')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'pg.perusahaan_id')
            ->leftJoin('master_perusahaan_alamat as mpa1', 'mpa1.id', '=', 'pg.alamat_id')
            ->leftjoin('master_perusahaans as mp2', 'mp2.id', '=', 'pg.perusahaan_lokal_id')
            ->leftJoin('master_perusahaan_alamat as mpa2', 'mpa2.id', '=', 'pg.alamat_lokal_id')
            ->leftjoin('master_perusahaans as mp3', 'mp3.id', '=', 'pg.perusahaan_pengembang_id')
            ->leftJoin('master_perusahaan_alamat as mpa3', 'mpa3.id', '=', 'pg.alamat_pengembang_id')
            ->leftjoin('users as u1', 'u1.id', '=', 'pg.verifikator1')
            ->leftjoin('users as u2', 'u2.id', '=', 'pg.verifikator2')
            ->leftjoin('users as u3', 'u3.id', '=', 'pg.verifikator3')
            ->leftjoin('users as u4', 'u4.id', '=', 'pg.verifikator4')
            ->leftjoin('users as u5', 'u5.id', '=', 'pg.verifikator5')
            ->leftjoin('users as uetc', 'uetc.id', '=', 'pg.etc')

            ->select(
                'pg.id',
                'pg.no_ref',
                'pg.tgl_mulai',
                'pg.tgl_akhir',
                'pg.status',
                'pg.jml_produk',
                'pg.check_self',
                'pg.nilai_self',
                'pg.jml_vendor',
                'pg.jml_bahan_baku',
                'p.nama_permen',
                DB::raw('p.id as permen_id'),
                'u1.name as v1',
                'u2.name as v2',
                'u3.name as v3',
                'u4.name as v4',
                'u5.name as v5',
                'uetc.name as uetc',
                'pg.perusahaan_id',
                'pg.alamat_id',
                'pg.perusahaan_lokal_id',
                'pg.alamat_lokal_id',
                'pg.perusahaan_pengembang_id',
                'pg.alamat_pengembang_id',
                DB::raw('CONCAT(COALESCE(mp.badan,"")," ",mp.nama) as nama'),
                DB::raw('CONCAT(mpa1.alamat,", ",mpa1.kelurahan,", ",mpa1.kecamatan,", ",mpa1.kabupaten,", ",mpa1.provinsi) as alamat'),
                DB::raw('CONCAT(COALESCE(mp2.badan,"")," ",mp2.nama) as nama_lokal'),
                DB::raw('CONCAT(mpa2.alamat,", ",mpa2.kelurahan,", ",mpa2.kecamatan,", ",mpa2.kabupaten,", ",mpa2.provinsi) as alamat_lokal'),
                DB::raw('CONCAT(COALESCE(mp3.badan,"")," ",mp3.nama) as nama_pengembang'),
                DB::raw('CONCAT(mpa3.alamat,", ",mpa3.kelurahan,", ",mpa3.kecamatan,", ",mpa3.kabupaten,", ",mpa3.provinsi) as alamat_pengembang'),
            )
            ->where('pg.id', $id)
            ->get();
        // verifikator
        $v = "<ol style='padding-left:20px'>";
        if ($penugasan[0]->v1 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v1;
            $v .= "</li>";
        }
        if ($penugasan[0]->v2 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v2;
            $v .= "</li>";
        }
        if ($penugasan[0]->v3 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v3;
            $v .= "</li>";
        }
        if ($penugasan[0]->v4 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v4;
            $v .= "</li>";
        }
        if ($penugasan[0]->v5 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v5;
            $v .= "</li>";
        }
        $v .= "</ol>";
        // etc
        $etc = "-";
        if ($penugasan[0]->uetc != "") {
            $etc = $penugasan[0]->uetc;
        }

        $kelompok = DB::table('master_barang_jasa')->get();
        $jumlahProduk = DB::table('verifikasi_produks as v')
            ->join('verifikasi_produk_files as f', 'f.ver_produk_id', '=', 'v.id')
            ->where('v.penugasan_id', $id)
            ->whereNotNull('f.nama_file')
            ->get(array('f.id'));
        $jumlahVerify = count($jumlahProduk);

        $perusahaan = DB::table('master_perusahaans')->get();
        return view('verifikasi.mulai')->with(compact('id', 'penugasan', 'kelompok', 'jumlahVerify', 'v', 'etc', 'perusahaan'));
    }

    public function getDataVerProduk()
    {

        $penugasan_id = $_GET['id'];
        $data = array();
        $query = DB::table('verifikasi_produks as v')
            ->join('penugasans as pg', 'pg.id', '=', 'v.penugasan_id')
            ->leftJoin('verifikasi_produk_files as f', function ($join) {
                $join->on('v.id', '=', 'f.ver_produk_id');
                $join->where('f.status', '=', 1);
            })
            ->leftJoin('master_barang_jasa as m', 'm.id', '=', 'v.kelompok_id')

            ->select(array('v.id', 'v.kelompok_id', 'v.bidang_usaha', 'v.jenis_produk', 'v.tipe', 'v.spesifikasi', 'f.nama_file', 'f.nama_file_asli', 'f.id as file_id', 'm.nama as nama_kelompok', 'v.capaian_tkdn', 'v.merk'))
            ->where('pg.id', $penugasan_id)
            ->groupBy('v.id')
            ->get();

        $data['data'] = array();
        for ($i = 0; $i < count($query); $i++) {
            $row["no"] = ($i + 1);
            $row["id"] = $query[$i]->id;
            $row["kelompok"] = $query[$i]->nama_kelompok;
            $row["bidang_usaha"] = $query[$i]->bidang_usaha;
            $row["jenis_produk"] = $query[$i]->jenis_produk;
            $row["tipe"] = $query[$i]->tipe;
            $row["spesifikasi"] = $query[$i]->spesifikasi;
            $row["merk"] = $query[$i]->merk;
            $row["capaian_tkdn"] = '<center><b>' . $query[$i]->capaian_tkdn . '</b></center>';
            if ($query[$i]->nama_file == "") {
                $row["file"] = '<center>-</center>';
                $row["status"] = '<center><i><span class="badge badge-warning">Belum Diverifikasi</span></i></center>';
            } else {
                $row["file"] = '<a href="' . URL::to('verifikasi/downloadHasil/' . $query[$i]->file_id) . '">' . $query[$i]->nama_file_asli . '</a>';
                $row["status"] = '<center><i><span class="badge badge-success">Telah Diverifikasi</span></i></center>';
            }
            $row["action"] = '<div class="btn-group ">
                                    <a href="' . URL::to("verifikasi/view/" . $query[$i]->id) . '" class="btn btn-sm btn-primary text-left"><i class="fa fa-search"></i> Detail</a>

                                </div>';
            // <a href="#" class="btn btn-sm btn-success text-left btn-modal-upload" data-toggle="modal" data-target="#modal-upload" data-produk_id="'.$query[$i]->id.'"><i class="fa fa-file-excel"></i></a>
            //     <a href="#" data-toggle="modal" data-target="#modal-editproduk" class="btn btn-sm btn-warning text-left" data-produk_id="'.$query[$i]->id.'"><i class="fa fa-pencil"></i></a>
            $data['data'][] = $row;
        }
        return response()->json($data, 200);
    }

    public function getDataVerProduk2()
    {
        $penugasan_id = @$_GET['id'];
        $cekPenugasan = DB::table('penugasans')->find($penugasan_id);
        $permen_id = $cekPenugasan->permen_id;
        $data['data'] = array();
        if ($permen_id == 6) {
            $query = DB::table('verifikasi_produks as v')
                ->join('penugasans as pg', 'pg.id', '=', 'v.penugasan_id')
                ->leftJoin('master_barang_jasa as m', 'm.id', '=', 'v.kelompok_id')
                ->select(array('v.id', 'v.kelompok_id', 'v.bidang_usaha', 'v.jenis_produk', 'v.tipe', 'v.spesifikasi', 'm.nama as nama_kelompok'))
                ->where('pg.id', $penugasan_id)
                ->whereExists(function ($query) {
                    $query->select("f.nama_file")
                        ->from('verifikasi_produk_files as f')
                        ->whereRaw('v.id = f.ver_produk_id')
                        ->whereRaw('f.jenis_id = 9');
                })
                ->get();
        } else {
            $query = DB::table('verifikasi_produks as v')
                ->join('penugasans as pg', 'pg.id', '=', 'v.penugasan_id')
                ->leftJoin('master_barang_jasa as m', 'm.id', '=', 'v.kelompok_id')
                ->select(array('v.id', 'v.kelompok_id', 'v.bidang_usaha', 'v.jenis_produk', 'v.tipe', 'v.spesifikasi', 'm.nama as nama_kelompok'))
                ->where('pg.id', $penugasan_id)
                ->whereExists(function ($query) {
                    $query->select("f.nama_file")
                        ->from('verifikasi_produk_files as f')
                        ->whereRaw('v.id = f.ver_produk_id');
                })
                ->get();
        }
        $no = 1;
        for ($i = 0; $i < count($query); $i++) {
            $cekLaporan = DB::table('laporan_details')->where('ver_produk_id', $query[$i]->id)->get();
            if (!isset($cekLaporan[0])) {
                $row["no"] = $no++;
                $row["id"] = $query[$i]->id;
                $row["kelompok"] = $query[$i]->nama_kelompok;
                $row["bidang_usaha"] = $query[$i]->bidang_usaha;
                $row["jenis_produk"] = $query[$i]->jenis_produk;
                $row["tipe"] = $query[$i]->tipe;
                $row["spesifikasi"] = $query[$i]->spesifikasi;
                /*if($query[$i]->nama_file == ""){
                    $row["file"] = '<center>-</center>';
                    $row["status"] = '<center><i><span class="badge badge-warning">N/A</span></i></center>';
                }else{
                    $row["file"] = $query[$i]->nama_file;
                    $row["status"] = '<center><i><span class="badge badge-success">Telah Diverifikasi</span></i></center>';
                }*/
                $row["action"] = '<div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="produk_id[]" value="' . $query[$i]->id . '">
                              <label class="form-check-label"></label>
                            </div>
                          </div>';
                $data['data'][] = $row;
            }
        }
        return response()->json($data, 200);
    }

    public function view($ver_id)
    {
        $role = Auth::user()->roles->pluck('name');
        $verProduk = DB::table('verifikasi_produks as v')
            ->join('penugasans as pg', 'pg.id', '=', 'v.penugasan_id')
            ->where('v.id', $ver_id)
            ->get(array('pg.permen_id', DB::raw('v.*')));
        $permen_id = $verProduk[0]->permen_id;

        $kelompok = DB::table('master_barang_jasa')->get();

        $jenis = DB::table('master_jenis_file')
            ->where('permen_id', '6')
            ->where('jenis_kbl', $verProduk[0]->jenis_kbl)
            ->get();

        if ($permen_id == 6) {
            $files = DB::table('verifikasi_produk_files as f')
                ->join('verifikasi_produks as v', 'v.id', '=', 'f.ver_produk_id')
                ->where('f.ver_produk_id', $ver_id)
                ->orderBy('f.rev', 'DESC')
                ->get(array(DB::raw('f.*'), 'v.capaian_tkdn'));


            return view('verifikasi.viewPermenNew')->with(compact('ver_id', 'verProduk', 'kelompok', 'permen_id', 'role', 'jenis', 'files'));
        } else {
            return view('verifikasi.viewPermen1')->with(compact('ver_id', 'verProduk', 'kelompok', 'permen_id', 'role'));
        }
        // elseif ($permen_id == 2) {
        //     return view('verifikasi.viewPermen2')->with(compact('ver_id','verProduk','kelompok','permen_id'));
        // }elseif ($permen_id == 3) {
        //     return view('verifikasi.viewPermen3')->with(compact('ver_id','verProduk','kelompok','permen_id'));
        // }elseif ($permen_id == 4) {
        //     return view('verifikasi.viewPermen4')->with(compact('ver_id','verProduk','kelompok','permen_id'));
        // }elseif ($permen_id == 5) {
        //     return view('verifikasi.viewPermen5')->with(compact('ver_id','verProduk','kelompok','permen_id'));
        // }else{
        //     return view('verifikasi.viewPermen6')->with(compact('ver_id','verProduk','kelompok','permen_id'));
        // }
    }

    public function getEditProduk()
    {
        $produk_id = $_GET['produk_id'];
        $query = DB::table('verifikasi_produks')->find($produk_id);
        echo json_encode($query);
    }

    public function prosesEditProduk(Request $request, $redirect = "")
    {
        $penugasan_id = $request->penugasan_id;
        $ver_produk_id = $request->ver_produk_id;
        $dataUpdate = array(
            'kelompok_id' => $request->kelompok_id,
            'bidang_usaha' => $request->bidang_usaha,
            'jenis_produk' => $request->jenis_produk,
            'tipe' => $request->tipe,
            'spesifikasi' => $request->spesifikasi,
            'merk' => $request->merk,
            'kode_hs' => $request->kode_hs,
            'nie' => $request->nie,
            'standar_produk' => $request->standar_produk,
            'sertifikat_produk' => $request->sertifikat_produk,
            'kapasitas_izin' => $request->kapasitas_izin,
            'kapasitas_vki' => $request->kapasitas_vki,
        );
        if (isset($request->jenis_kbl)) {
            $dataUpdate['jenis_kbl'] = $request->jenis_kbl;
        }
        if(isset($request->nomor_persetujuan)){
            $dataUpdate['nomor_persetujuan'] = $request->nomor_persetujuan;
        }
        DB::table('verifikasi_produks')->where('id', $ver_produk_id)->update($dataUpdate);

        // if ($redirect == "") {
        //     return redirect('verifikasi/mulai/'.$penugasan_id);
        // }else{
        Session::flash('success', 'Data Berhasil Disimpan!');
        return redirect('verifikasi/view/' . $ver_produk_id);
        // }
    }

    public function getExcelProduk()
    {
        $ver_produk_id = $_GET['ver_produk_id'];
        $data['data'] = array();
        $query = DB::table('verifikasi_produk_files as f')
            ->join('verifikasi_produks as v', 'v.id', '=', 'f.ver_produk_id')
            ->where('f.ver_produk_id', $ver_produk_id)
            ->orderBy('f.rev', 'DESC')
            ->get(array(DB::raw('f.*'), 'v.capaian_tkdn'));

        for ($i = 0; $i < count($query); $i++) {
            $row["no"] = ($i + 1);
            $row["id"] = $query[$i]->id;
            $row["nama_file"] = '<a href="' . URL::to('verifikasi/downloadHasil/' . $query[$i]->id) . '">' . $query[$i]->nama_file_asli . '</a>';
            $row["capaian_tkdn"] = $query[$i]->capaian_tkdn;
            $row["action"] = '<div class="btn-group-vertical ">
                                <a href="#" onclick="klikDelete(formdel' . $query[$i]->id . ')" class="btn btn-sm btn-outline-danger text-left">
                                    <i class="fa fa-trash"></i>&nbsp; Delete
                                </a>
                                <form id="formdel' . $query[$i]->id . '" method="POST" action="' . URL::to('verifikasi/delete/' . $query[$i]->id) . '">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                </div>';
            $data['data'][] = $row;
        }
        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $verProduk = DB::table('verifikasi_produk_files as f')
            ->where('f.id', '=', $id)
            ->first();
        $ver_produk_id = $verProduk->ver_produk_id;
        DB::table('verifikasi_produk_files')->where('id', '=', $id)->delete();
        DB::table('verifikasi_produks')->where('id', $ver_produk_id)->update(['capaian_tkdn' => NULL]);
        return redirect('verifikasi/view/' . $ver_produk_id)->with('status', 'Data berhasil dihapus!');;
    }

    public function downloadHasil($verProdFile_id)
    {
        $verProdFile = DB::table('verifikasi_produk_files')->find($verProdFile_id);
        $file = $verProdFile->path . $verProdFile->nama_file;
        return Response::download($file, $verProdFile->nama_file_asli);
    }

    public function download($permen_id, $jenis_kbl = null)
    {
        if ($permen_id == 1) {
            $filename = 'Template PERMENPERIN No. 16 Th 2011.xlsx';
        } elseif ($permen_id == 2) {
            $filename = 'Template PERMENPERIN No. 22 Th 2020.xlsx';
        } elseif ($permen_id == 3) {
            $filename = 'Template PERMENPERIN No. 16 Th 2020.xlsx';
        } elseif ($permen_id == 4) {
            $filename = 'Template PERMENPERIN No. 04 Th 2017.xlsx';
        } elseif ($permen_id == 5) {
            $filename = 'Template PERMENPERIN No. 29 Th 2017.xlsx';
        } elseif ($permen_id == 6) {
            if ($jenis_kbl != null) {
                if ($jenis_kbl == 1) {
                    $filename = 'TKDN KBL R2 dan R3.zip';
                } else if ($jenis_kbl == 2) {
                    $filename = 'TKDN KBL R4 atau Lebih.zip';
                }
            }
            //$filename = 'Template PERMENPERIN No. 27 Th 2020.xlsx';
        }
        $path = public_path('template/' . $filename);
        return Response::download($path);
    }

    public function uploadExcel(Request $request)
    {
        $now = date("Y-m-d H:i:s");
        $penugasan_id = $request->penugasan_id;
        $ver_produk_id = $request->ver_produk_id;
        if (isset($request->jenis_id)) {
            $jenis_id = $request->jenis_id;
        }
        $penugas = DB::table('penugasans')->where('id', $penugasan_id)->first();
        $verProduk = DB::table('verifikasi_produks')->where('id', $ver_produk_id)->first();

        $nama_file_asli = $request->file->getClientOriginalName();
        $nama_file = time() . '.' . $request->file->extension();

        $capaian_tkdn = null;
        if ($penugas->permen_id == 1) {
            $path = storage_path('app/public/excel/Permen162011/');
            $request->file->move($path, $nama_file);
            $inputFileName = $path . $nama_file;

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $data = array();
            # FORM 1.1 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.1");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form1.1'][] = $rows[$i];
            }

            # FORM 1.2 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.2");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form1.2'][] = $rows[$i];
            }

            # FORM 1.3 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.3");

            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form1.3'][] = $rows[$i];
            }

            # FORM 1.4 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.4");

            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form1.4'][] = $rows[$i];
            }

            # FORM 1.5 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.5");

            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form1.5'][] = $rows[$i];
            }

            # FORM 1.6 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.6");

            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form1.6'][] = $rows[$i];
            }

            # FORM 1.7 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.7");

            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form1.7'][] = $rows[$i];
            }

            # FORM 1.8 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.8");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                // array_splice($rows[$i], 46, 20000);
                $data['form1.8'][] = $rows[$i];
            }

            # FORM 1.9 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.9");

            $rows = $worksheet->toArray();
            // $jumlah = count($rows);
            $jumlah = 29;
            for ($i = 14; $i < $jumlah; $i++) {
                $data['form1.9'][] = $rows[$i];
            }
            $capaian_tkdn = ($data['form1.9'][14][7]);
        } elseif ($penugas->permen_id == 2) {
            $path = storage_path('app/public/excel/Permen222020/');
            $request->file->move($path, $nama_file);
            $inputFileName = $path . $nama_file;

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $data = array();
            # FORM 1.1 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.1");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "") {
                    $data['form1.1'][] = $rows[$i];
                }
                if (trim($rows[$i][1]) == "TOTAL") {
                    break;
                }
            }
            // echo "<pre>";
            // print_r($data);die;
            # End Form 1.1 #
            # FORM 1.2 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.2");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "") {
                    $data['form1.2'][] = $rows[$i];
                }
                if (trim($rows[$i][1]) == "TOTAL") {
                    break;
                }
            }
            # End Form 1.2 #
            # FORM 1.3 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.3");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][6] != "") {
                    $data['form1.3'][] = $rows[$i];
                }
                if (trim($rows[$i][6]) == "Biaya produksi per 1(satu) satuan produk") {
                    break;
                }
            }
            # End Form 1.3 #
            # FORM 1.4 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.4");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][6] != "") {
                    $data['form1.4'][] = $rows[$i];
                }
                if (trim($rows[$i][6]) == "Biaya produksi per 1(satu) satuan produk") {
                    break;
                }
            }
            # End Form 1.4 #
            # FORM 1.5 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.5");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][6] != "") {
                    $data['form1.5'][] = $rows[$i];
                }
                if (trim($rows[$i][6]) == "Biaya produksi per 1(satu) satuan produk") {
                    break;
                }
            }
            # End Form 1.5 #
            # FORM 1.6 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.6");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][8] != "") {
                    $data['form1.6'][] = $rows[$i];
                }
                if (trim($rows[$i][8]) == "Biaya produksi per 1 (satu) satuan produk") {
                    break;
                }
            }
            # End Form 1.6 #
            # FORM 1.7 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.7");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][9] != "") {
                    $data['form1.7'][] = $rows[$i];
                }
                if (trim($rows[$i][9]) == "Biaya produksi per 1 (satu) satuan produk") {
                    break;
                }
            }
            # End Form 1.7 #
            # FORM 1.8 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.8");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][6] != "") {
                    $data['form1.8'][] = $rows[$i];
                }
                if (trim($rows[$i][6]) == "Biaya produksi per 1 (satu) satuan produk") {
                    break;
                }
            }
            # End Form 1.8 #
            # FORM 1.9 ############
            $worksheet = $spreadsheet->getSheetByName("Form 1.9");
            $rows = $worksheet->toArray();
            $jumlah = 28;
            for ($i = 13; $i < $jumlah; $i++) {
                $data['form1.9'][] = $rows[$i];
            }
            # End Form Pengembangan #
            #  Pengembangan ############
            $worksheet = $spreadsheet->getSheetByName("Pengembangan");
            $rows = $worksheet->toArray();
            $jumlah = 35;
            for ($i = 16; $i < $jumlah; $i++) {
                $data['pengembangan'][] = $rows[$i];
            }
            # End  Pengembangan #
            #  Rekapitulasi ############
            $worksheet = $spreadsheet->getSheetByName("Rekapitulasi TKDN");
            $rows = $worksheet->toArray();
            $jumlah = 30;
            $x = 0;
            for ($i = 17; $i < $jumlah; $i++) {
                $data['rekapitulasi'][$x][0] = $rows[$i][2];
                $data['rekapitulasi'][$x][1] = $rows[$i][3];
                $data['rekapitulasi'][$x][2] = $rows[$i][4];
                $data['rekapitulasi'][$x][3] = $rows[$i][5];
                $data['rekapitulasi'][$x][4] = $rows[$i][6];
                $data['rekapitulasi'][$x][5] = $rows[$i][7];
                $data['rekapitulasi'][$x][6] = $rows[$i][8];
                $data['rekapitulasi'][$x][7] = $rows[$i][9];
                $x++;
            }
            $capaian_tkdn = ($data['rekapitulasi'][6][7] * 100);
            # End  Rekapitulasi #
        } elseif ($penugas->permen_id == 3) {
            $path = storage_path('app/public/excel/Permen162020/');
            $request->file->move($path, $nama_file);
            $inputFileName = $path . $nama_file;

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $data = array();
            # FORM 1. Kandungan Bahan Baku ############
            $worksheet = $spreadsheet->getSheetByName("Form 1. Kandungan Bahan Baku");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][2] != "") {
                    $data['form1'][] = $rows[$i];
                }
                if (trim($rows[$i][0]) == "Total Nilai TKDN Bahan Baku") {
                    break;
                }
            }
            // dd($data['form1']);
            # End Form 1. Kandungan Bahan Baku #
            # Form 2. Penelitian & Pengembang ############
            $worksheet = $spreadsheet->getSheetByName("Form 2. Penelitian & Pengembang");
            $rows = $worksheet->toArray();
            $jumlah = 21;
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form2'][] = $rows[$i];
            }
            // dd($data['form2']);
            # End Form 2. Penelitian & Pengembang #
            # Form 3. Produksi ############
            $worksheet = $spreadsheet->getSheetByName("Form 3. Produksi");
            $rows = $worksheet->toArray();
            $jumlah = 19;
            for ($i = 16; $i < $jumlah; $i++) {
                $data['form3'][] = $rows[$i];
            }
            // dd($data['form3']);
            # End Form 3. Produksi #
            # Form 4. Proses Pengemasan ############
            $worksheet = $spreadsheet->getSheetByName("Form 4. Proses Pengemasan");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            for ($i = 16; $i < $jumlah; $i++) {
                if ($rows[$i][0] != "" || $rows[$i][1] != "" || $rows[$i][2] != "") {
                    $data['form4'][] = $rows[$i];
                }
                if (trim($rows[$i][0]) == "Total Nilai TKDN Bahan Baku") {
                    break;
                }
            }
            // dd($data['form4']);
            # End Form 4. Proses Pengemasan #
            # Rekapitulasi TKDN Farmasi ############
            $worksheet = $spreadsheet->getSheetByName("Rekapitulasi TKDN Farmasi");
            $rows = $worksheet->toArray();
            $jumlah = 21;
            for ($i = 16; $i < $jumlah; $i++) {
                $data['rekapitulasi'][] = $rows[$i];
            }
            $capaian_tkdn = ($data['rekapitulasi'][4][6] * 100);
            # End Rekapitulasi TKDN Farmasi #
        } elseif ($penugas->permen_id == 4) {
            $path = storage_path('app/public/excel/Permen042017/');
            $request->file->move($path, $nama_file);
            $inputFileName = $path . $nama_file;

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $data = array();
            # Form Penghitungan ############
            $worksheet = $spreadsheet->getSheetByName("Form Penghitungan");
            $rows = $worksheet->toArray();
            $jumlah = 38;
            for ($i = 15; $i < $jumlah; $i++) {
                unset($rows[$i][0]);
                $rows[$i] = array_values($rows[$i]);
                $data['formhitung'][] = $rows[$i];
            }
            $capaian_tkdn = ($data['formhitung'][22][9] * 100);
            // dd($data['formhitung']);
            # End Form Penghitungan #
        } elseif ($penugas->permen_id == 5) {
            $path = storage_path('app/public/excel/Permen292017/');
            $request->file->move($path, $nama_file);
            $inputFileName = $path . $nama_file;

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $data = array();
            # Manufaktur ############
            $worksheet = $spreadsheet->getSheetByName("Manufaktur");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            $x = 0;
            for ($i = 15; $i < $jumlah; $i++) {
                if ($rows[$i][2] != "" || $rows[$i][4] != "" || $rows[$i][5] != "" || $rows[$i][7] != "") {
                    $data['manufaktur'][$x][] = $rows[$i][1];
                    $data['manufaktur'][$x][] = $rows[$i][2];
                    $data['manufaktur'][$x][] = $rows[$i][3];
                    $data['manufaktur'][$x][] = $rows[$i][4];
                    $data['manufaktur'][$x][] = $rows[$i][5];
                    $data['manufaktur'][$x][] = $rows[$i][6];
                    $data['manufaktur'][$x][] = $rows[$i][7];
                    $data['manufaktur'][$x][] = $rows[$i][8];
                    $data['manufaktur'][$x][] = $rows[$i][9];
                    $data['manufaktur'][$x][] = $rows[$i][10];
                    $data['manufaktur'][$x][] = $rows[$i][11];
                    $data['manufaktur'][$x][] = $rows[$i][12];
                    $data['manufaktur'][$x][] = $rows[$i][13];
                    $data['manufaktur'][$x][] = $rows[$i][14];
                    $data['manufaktur'][$x][] = $rows[$i][15];
                    $x++;
                }
            }
            # End Manufaktur #
            # pengembangan ############
            $worksheet = $spreadsheet->getSheetByName("Pengembangan");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            $x = 0;
            for ($i = 19; $i < $jumlah; $i++) {
                if ($rows[$i][1] != "" || $rows[$i][2] != "") {
                    $data['pengembangan'][$x][] = $rows[$i][1];
                    $data['pengembangan'][$x][] = $rows[$i][2];
                    $data['pengembangan'][$x][] = $rows[$i][3];
                    $data['pengembangan'][$x][] = $rows[$i][4];
                    $data['pengembangan'][$x][] = $rows[$i][5];
                    $data['pengembangan'][$x][] = $rows[$i][6];
                    $data['pengembangan'][$x][] = $rows[$i][7];
                    $data['pengembangan'][$x][] = $rows[$i][8];
                    $data['pengembangan'][$x][] = $rows[$i][9];
                    $data['pengembangan'][$x][] = $rows[$i][10];
                    $data['pengembangan'][$x][] = $rows[$i][11];
                    $data['pengembangan'][$x][] = $rows[$i][12];
                    $data['pengembangan'][$x][] = $rows[$i][13];
                    $data['pengembangan'][$x][] = $rows[$i][14];
                    $data['pengembangan'][$x][] = $rows[$i][15];
                    $data['pengembangan'][$x][] = $rows[$i][16];
                    $data['pengembangan'][$x][] = $rows[$i][17];
                    $data['pengembangan'][$x][] = $rows[$i][18];
                    $data['pengembangan'][$x][] = $rows[$i][19];
                    $data['pengembangan'][$x][] = $rows[$i][20];
                    $x++;
                }
            }
            # End pengembangan #
            # Software ############
            $worksheet = $spreadsheet->getSheetByName("Software");
            $rows = $worksheet->toArray();
            $jumlah = count($rows);
            $x = 0;
            for ($i = 14; $i < $jumlah; $i++) {
                $data['software'][] = $rows[$i];
            }
            # End Software #
            # Rekap ############
            $worksheet = $spreadsheet->getSheetByName("Rekap");
            $rows = $worksheet->toArray();
            $jumlah = 23;
            $x = 0;
            for ($i = 16; $i < $jumlah; $i++) {
                $data['rekap'][] = $rows[$i];
            }
            $capaian_tkdn = $data['rekap'][6][4] * 100;
            # End Rekap #
        }
        /* elseif ($penugas->permen_id == 6) {
            $path = storage_path('app/public/excel/Permen272020/');
            $request->file->move($path, $nama_file);
            $inputFileName = $path . $nama_file;

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $data= array();
            # Rekapitulasi TKDN ############
            $worksheet = $spreadsheet->getSheetByName("Rekapitulasi TKDN");
            $rows = $worksheet->toArray();
            $jumlah = 38;
            for ($i=17; $i < $jumlah; $i++) {
                $data['rekapitulasi'][] = $rows[$i];
            }
            $capaian_tkdn = $data['rekapitulasi'][20][10]*100;
            # End Rekapitulasi TKDN #
            # Pengembangan  ############
            $worksheet = $spreadsheet->getSheetByName("Pengembangan");
            $rows = $worksheet->toArray();
            $jumlah = 28;
            for ($i=15; $i < $jumlah; $i++) {
                array_splice($rows[$i], 46, 20000);
                $data['pengembangan'][] = $rows[$i];
            }
            # End Pengembangan  #
        }*/ elseif ($penugas->permen_id == 6) {
            $path = storage_path('app/public/excel/Permen272020/');
            $request->file->move($path, $nama_file);
            $inputFileName = $path . $nama_file;

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $data = array();

            if ($jenis_id == 1) { //Body
                # FORM 1.1 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.1");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 25; $j++) {
                        $data['FORM1_1'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.2 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.2");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_2'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.3 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.3");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_3'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.4 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.4");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 15; $j++) {
                        $data['FORM1_4'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.5 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.5");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_5'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.6 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.6");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_6'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.7 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.7");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 13; $j++) {
                        $data['FORM1_7'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.8 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.8");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_8'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.9 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.9");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 7; $j++) {
                        $data['FORM1_9'][$i][$j] = $rows[$i][$j];
                    }
                }
                //                $capaian_tkdn = $data['FORM1_9'][26][6]*100;
            } else if ($jenis_id == 2) { //Baterai
                # FORM 1.1 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.1");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 25; $j++) {
                        $data['FORM1_1'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.2 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.2");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_2'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.3 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.3");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_3'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.4 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.4");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_4'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.5 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.5");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_5'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.6 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.6");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 12; $j++) {
                        $data['FORM1_6'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.7 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.7");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 13; $j++) {
                        $data['FORM1_7'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.8 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.8");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_8'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.9 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.9");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 6; $j++) {
                        $data['FORM1_9'][$i][$j] = $rows[$i][$j];
                    }
                }
                //                $capaian_tkdn = $data['FORM1_9'][26][6]*100;
            } else if ($jenis_id == 3 || $jenis_id == 4) { //Drive Train || Sistem Setir
                # FORM 1.1 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.1");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 25; $j++) {
                        $data['FORM1_1'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.2 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.2");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_2'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.3 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.3");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                $jml = 21;
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_3'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.4 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.4");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 15; $j++) {
                        $data['FORM1_4'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.5 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.5");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_5'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.6 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.6");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 12; $j++) {
                        $data['FORM1_6'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.7 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.7");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 13; $j++) {
                        $data['FORM1_7'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.8 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.8");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_8'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.9 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.9");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 6; $j++) {
                        $data['FORM1_9'][$i][$j] = $rows[$i][$j];
                    }
                }
                //                $capaian_tkdn = $data['FORM1_9'][26][6]*100;
            } else if ($jenis_id == 5) { //Sistem Pengereman
                # FORM 1.1 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.1");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 25; $j++) {
                        $data['FORM1_1'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.2 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.2");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_2'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.3 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.3");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_3'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.4 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.4");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 15; $j++) {
                        $data['FORM1_4'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.5 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.5");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_5'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.6 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.6");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 12; $j++) {
                        $data['FORM1_6'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.7 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.7");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 13; $j++) {
                        $data['FORM1_7'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.8 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.8");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_8'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.9 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.9");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 7; $j++) {
                        $data['FORM1_9'][$i][$j] = $rows[$i][$j];
                    }
                }
                //                $capaian_tkdn = $data['FORM1_9'][26][6]*100;
            } else if ($jenis_id == 6) { //Roda
                # FORM 1.1 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.1");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 25; $j++) {
                        $data['FORM1_1'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.2 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.2");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_2'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.3 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.3");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_3'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.4 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.4");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 15; $j++) {
                        $data['FORM1_4'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.5 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.5");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_5'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.6 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.6");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_6'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.7 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.7");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 13; $j++) {
                        $data['FORM1_7'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.8 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.8");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_8'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.9 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.9");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 6; $j++) {
                        $data['FORM1_9'][$i][$j] = $rows[$i][$j];
                    }
                }
                //                $capaian_tkdn = $data['FORM1_9'][26][6]*100;
            } else if ($jenis_id == 7) { //Electrical Instrumen
                # FORM 1.1 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.1");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 25; $j++) {
                        $data['FORM1_1'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.2 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.2");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_2'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.3 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.3");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_3'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.4 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.4");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 15; $j++) {
                        $data['FORM1_4'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.5 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.5");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_5'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.6 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.6");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 12; $j++) {
                        $data['FORM1_6'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.7 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.7");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 13; $j++) {
                        $data['FORM1_7'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.8 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.8");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_8'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.9 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.9");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 6; $j++) {
                        $data['FORM1_9'][$i][$j] = $rows[$i][$j];
                    }
                }
                //                $capaian_tkdn = $data['FORM1_9'][26][6]*100;
            } else if ($jenis_id == 8) { //Komponen Universal
                # FORM 1.1 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.1");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 25; $j++) {
                        $data['FORM1_1'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.2 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.2");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_2'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.3 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.3");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j < count($rows[$i]); $j++) {
                        $data['FORM1_3'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.4 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.4");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 15; $j++) {
                        $data['FORM1_4'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.5 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.5");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_5'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.6 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.6");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 12; $j++) {
                        $data['FORM1_6'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.7 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.7");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 13; $j++) {
                        $data['FORM1_7'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.8 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.8");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 10; $j++) {
                        $data['FORM1_8'][$i][$j] = $rows[$i][$j];
                    }
                }

                # FORM 1.9 ############
                $worksheet = $spreadsheet->getSheetByName("FORM 1.9");
                $rows = $worksheet->toArray();
                $jumlah = count($rows);
                for ($i = 0; $i < $jumlah; $i++) {
                    for ($j = 0; $j <= 6; $j++) {
                        $data['FORM1_9'][$i][$j] = $rows[$i][$j];
                    }
                }
                // $capaian_tkdn = $data['FORM1_9'][26][6]*100;
            } else if ($jenis_id == 9) { //Rekapitulasi
                # Rekapitulasi TKDN ############
                $worksheet = $spreadsheet->getSheetByName("Rekapitulasi TKDN");
                $rows = $worksheet->toArray();
                $jumlah = 38;
                for ($i = 17; $i < $jumlah; $i++) {
                    $data['rekapitulasi'][] = $rows[$i];
                }

                $komponen_utama = 0;
                $komponen_pendukung = 0;
                $perakitan = 0;
                $pengembangan = 0;
                if ($verProduk->jenis_kbl == 1) { //roda 2
                    $capaian_tkdn = $data['rekapitulasi'][20][10] * 100;

                    $komponen_utama = ($data['rekapitulasi'][4][10] * 100)+($data['rekapitulasi'][5][10] * 100)+($data['rekapitulasi'][6][10] * 100);
                    $komponen_pendukung = ($data['rekapitulasi'][8][10] * 100)+($data['rekapitulasi'][9][10] * 100)+($data['rekapitulasi'][10][10] * 100)+($data['rekapitulasi'][11][10] * 100)+($data['rekapitulasi'][12][10] * 100);
                    $perakitan = ($data['rekapitulasi'][16][10] * 100)+($data['rekapitulasi'][18][10] * 100);
                    $pengembangan = ($data['rekapitulasi'][19][10] * 100);
                } else  if ($verProduk->jenis_kbl == 2) { //roda 4
                    $capaian_tkdn = $data['rekapitulasi'][19][10] * 100;

                    $komponen_utama = ($data['rekapitulasi'][4][10] * 100)+($data['rekapitulasi'][5][10] * 100)+($data['rekapitulasi'][6][10] * 100);
                    $komponen_pendukung = ($data['rekapitulasi'][8][10] * 100)+($data['rekapitulasi'][9][10] * 100)+($data['rekapitulasi'][10][10] * 100)+($data['rekapitulasi'][11][10] * 100);
                    $perakitan = ($data['rekapitulasi'][15][10] * 100)+($data['rekapitulasi'][17][10] * 100);
                    $pengembangan = ($data['rekapitulasi'][18][10] * 100);
                }
                # End Rekapitulasi TKDN #
                # Pengembangan  ############
                $worksheet = $spreadsheet->getSheetByName("Pengembangan");
                $rows = $worksheet->toArray();
                $jumlah = 28;
                for ($i = 15; $i < $jumlah; $i++) {
                    array_splice($rows[$i], 46, 20000);
                    $data['pengembangan'][] = $rows[$i];
                }
                # End Pengembangan  #
            }
            // print_r($data);die();
        }
        $konten = json_encode($data);

        DB::beginTransaction();
        try {
            // update capaian_tkdn
            if (isset($capaian_tkdn)) {
                DB::table('verifikasi_produks')
                    ->where('id', $ver_produk_id)
                    ->update(['capaian_tkdn' => $capaian_tkdn]);
            }
            if (isset($komponen_utama)) {
                DB::table('verifikasi_produks')
                    ->where('id', $ver_produk_id)
                    ->update([
                        'komponen_utama' => $komponen_utama,
                        'komponen_pendukung' => $komponen_pendukung,
                        'perakitan' => $perakitan,
                        'pengembangan' => $pengembangan
                    ]);
            }

            // set all status to non active
            DB::table('verifikasi_produk_files')
                ->where('ver_produk_id', $ver_produk_id)
                ->update(['status' => 0]);

            // getn no revision
            $rev = DB::table('verifikasi_produk_files')
                ->where('ver_produk_id', $ver_produk_id)
                ->max('rev');
            if ($rev === NULL) {
                $rev = 0;
            } else {
                $rev = ($rev + 1);
            }

            $dataSave = array(
                'nama_file_asli' => $nama_file_asli,
                'nama_file' => $nama_file,
                'path' => $path,
                'konten' => $konten,
                'status' => 1,
                'rev' => $rev,
            );

            $cek = DB::table('verifikasi_produk_files')
                ->where('penugasan_id', $penugasan_id)
                ->where('ver_produk_id', $ver_produk_id)
                ->get();

            if (isset($jenis_id)) {
                $dataSave['jenis_id'] = $jenis_id;

                $cek = DB::table('verifikasi_produk_files')
                    ->where('penugasan_id', $penugasan_id)
                    ->where('ver_produk_id', $ver_produk_id)
                    ->where('jenis_id', $jenis_id)
                    ->get();
            }

            if (!isset($cek[0])) {
                $dataSave['penugasan_id'] = $penugasan_id;
                $dataSave['ver_produk_id'] = $ver_produk_id;
                $dataSave['created_at'] = $now;
                DB::table('verifikasi_produk_files')->insert($dataSave);
            } else {
                $dataSave['updated_at'] = $now;
                if (isset($jenis_id)) {
                    DB::table('verifikasi_produk_files')
                        ->where('penugasan_id', $penugasan_id)
                        ->where('ver_produk_id', $ver_produk_id)
                        ->where('jenis_id', $jenis_id)
                        ->update($dataSave);
                } else {
                    DB::table('verifikasi_produk_files')
                        ->where('penugasan_id', $penugasan_id)
                        ->where('ver_produk_id', $ver_produk_id)
                        ->update($dataSave);
                }
            }

            $dataSave['penugasan_id'] = $penugasan_id;
            $dataSave['ver_produk_id'] = $ver_produk_id;
            $dataSave['created_at'] = $now;
            DB::table('verifikasi_produk_history')->insert($dataSave);

            DB::commit();
            Session::flash('success', 'Data Berhasil Disimpan!');
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            echo "Upload Gagal $e";
            die;
            // something went wrong
        }

        return redirect('verifikasi/view/' . $ver_produk_id);
    }

    public function viewLaporan($penugasan_id)
    {
        $penugasan = DB::table('penugasans as pg')
            ->leftJoin('master_permens as p', 'p.id', '=', 'pg.permen_id')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'pg.perusahaan_id')
            ->leftjoin('users as u1', 'u1.id', '=', 'pg.verifikator1')
            ->leftjoin('users as u2', 'u2.id', '=', 'pg.verifikator2')
            ->leftjoin('users as u3', 'u3.id', '=', 'pg.verifikator3')
            ->leftjoin('users as u4', 'u4.id', '=', 'pg.verifikator4')
            ->leftjoin('users as u5', 'u5.id', '=', 'pg.verifikator5')
            ->leftjoin('users as uetc', 'uetc.id', '=', 'pg.etc')

            ->select(
                'pg.id',
                'pg.tgl_mulai',
                'pg.tgl_akhir',
                'pg.status',
                'pg.jml_produk',
                'mp.alamat_pusat',
                'p.nama_permen',
                DB::raw('p.id as permen_id'),
                'u1.name as v1',
                'u2.name as v2',
                'u3.name as v3',
                'u4.name as v4',
                'u5.name as v5',
                'uetc.name as uetc',
                DB::raw('CONCAT(COALESCE(mp.badan,"")," ",mp.nama,"<small>(",COALESCE(mp.alamat_pabrik,""),")</small>") as nama'),
            )
            ->where('pg.id', $penugasan_id)
            ->get();
        // verifikator
        $v = "<ol style='padding-left:20px'>";
        if ($penugasan[0]->v1 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v1;
            $v .= "</li>";
        }
        if ($penugasan[0]->v2 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v2;
            $v .= "</li>";
        }
        if ($penugasan[0]->v3 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v3;
            $v .= "</li>";
        }
        if ($penugasan[0]->v4 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v4;
            $v .= "</li>";
        }
        if ($penugasan[0]->v5 != "") {
            $v .= "<li>";
            $v .= $penugasan[0]->v5;
            $v .= "</li>";
        }
        $v .= "</ol>";
        // etc
        $etc = "-";
        if ($penugasan[0]->uetc != "") {
            $etc = $penugasan[0]->uetc;
        }

        $kelompok = DB::table('master_barang_jasa')->get();
        $jumlahProduk = DB::table('verifikasi_produks as v')
            ->join('verifikasi_produk_files as f', 'f.ver_produk_id', '=', 'v.id')
            ->where('v.penugasan_id', $penugasan_id)
            ->whereNotNull('f.nama_file')
            ->get(array('f.id'));
        $jumlahVerify = count($jumlahProduk);
        return view('verifikasi.viewLaporan')->with(compact('penugasan_id', 'penugasan', 'kelompok', 'jumlahVerify', 'v', 'etc'));
    }

    public function getLaporan($penugasan_id)
    {
        $role = Auth::user()->getRoleNames();
        $role = $role[0];
        $data = [];
        $query = DB::table('laporans as l')
            ->join('laporan_details as ld', 'l.id', '=', 'ld.laporan_id')
            ->leftjoin('master_perusahaans as p', 'l.perusahaan_id', '=', 'p.id')
            ->leftjoin('master_permens as mp', 'l.permen_id', '=', 'mp.id')
            ->select(array('l.id', 'l.no_laporan', 'l.tanggal', 'p.nama as nama_perusahaan', 'mp.nama_permen', 'mp.id as permen_id', 'l.name_cover'))
            ->where('l.penugasan_id', $penugasan_id)
            ->groupBy('l.id')
            ->orderBy('l.id', 'DESC')
            ->get();

        $data['data'] = array();
        if (count($query) > 0) {
            $no = 1;
            foreach ($query as $idx => $value) {
                $tanggal = implode("/", array_reverse(explode("-", $value->tanggal)));
                $row["no"] = ($no++);
                $row["id"] = $value->id;
                $row["no_laporan"] = '<center><b>' . $value->no_laporan . '</b></center>';
                $row["tanggal"] = '<center>' . $tanggal . '</center>';
                if ($value->name_cover == "") {
                    $row["name"] = "<center><i>N/A</i></center>";
                } else {
                    $row["name"] = $value->name_cover;
                }
                $row["action"] = '<div class="btn-group">';
                if ($role == "Admin" || $role == "Verifikator") {
                    $row["action"] .= '<a href="#" data-toggle="modal" data-target="#previewPDF" data-id="' . $value->id . '" data-url="' . URL::to('cetak-laporan/' . $value->id . '/preview') . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Preview</a>';
                    $row["action"] .= '<a href="#" data-toggle="modal" data-target="#modal-lampiran" data-id="' . $value->id . '" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Upload Lampiran</a>';
                    $row["action"] .= '<a href="#" data-toggle="modal" data-target="#modal-editdasarhukum" data-id="' . $value->id . '" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit Dasar Hukum</a>';
                    $row["action"] .= '<a href="#" onclick="klikDelete(formdellap' . $value->id . ')" class="btn btn-sm btn-outline-danger text-left">
                                    <i class="fa fa-trash"></i>&nbsp; Delete
                                </a>
                                <form id="formdellap' . $value->id . '" method="POST" action="' . URL::to('verifikasi/deleteLaporan/' . $value->id) . '">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>';
                }
                $row["action"] .= "</div>";

                $data['data'][] = $row;
            }
        }

        return response()->json($data, 200);
    }

    public function getLampiran()
    {
        $laporan_id = $_GET['laporan_id'];
        $role = Auth::user()->getRoleNames();
        $role = $role[0];
        $data = [];
        $query = DB::table('laporans as l')
            ->join('laporan_lampirans as lamp', 'l.id', '=', 'lamp.laporan_id')
            ->where('l.id', $laporan_id)
            ->get(array('lamp.id', 'nama_file', 'nama_file_asli', 'keterangan'));
        $data['data'] = array();
        if (count($query) > 0) {
            $no = 1;
            foreach ($query as $idx => $value) {
                $row["no"] = ($no++);
                $row["id"] = $value->id;
                $row["keterangan"] = $value->keterangan;
                $row["nama_file"] = '<a href="' . URL::to('verifikasi/downloadLamp/' . $value->id) . '">' . $value->nama_file_asli . '</a>';
                $row["action"] = '<div class="btn-group">
                                <a href="#" onclick="klikDelete(formdel' . $value->id . ')" class="btn btn-sm btn-outline-danger text-left">
                                    <i class="fa fa-trash"></i>&nbsp; Delete
                                </a>
                                <form id="formdel' . $value->id . '" method="POST" action="' . URL::to('verifikasi/deleteLamp/' . $value->id) . '">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                </div>';

                $data['data'][] = $row;
            }
        }

        return response()->json($data, 200);
    }

    public function downloadLamp($lampiran_id)
    {
        $lampiran = DB::table('laporan_lampirans')->find($lampiran_id);
        $file = $lampiran->path . $lampiran->nama_file;
        return Response::download($file, $lampiran->nama_file);
    }

    public function uploadLampiran(Request $request)
    {
        $laporan_id = $request->laporan_id;
        $laporan = DB::table('laporans')->find($laporan_id);
        $keterangan = $request->keterangan;
        $nama_file_asli = $request->file->getClientOriginalName();
        $nama_file = time() . '.' . $request->file->extension();
        $path = storage_path('app/public/lampiran/');
        $request->file->move($path, $nama_file);

        $dataInsert = array(
            'laporan_id' => $laporan_id,
            'keterangan' => $keterangan,
            'nama_file' => $nama_file,
            'nama_file_asli' => $nama_file_asli,
            'path' => $path,
        );
        DB::table('laporan_lampirans')->insertTs($dataInsert, true);

        Session::flash('success', 'Lampiran Berhasil Diupload!');
        return redirect('verifikasi/viewLaporan/' . $laporan->penugasan_id);
    }

    public function deleteLamp($id)
    {
        $lamp = DB::table('laporan_lampirans as ll')
            ->join('laporans as l', 'l.id', '=', 'll.laporan_id')
            ->where('ll.id', '=', $id)
            ->first();
        $penugasan_id = $lamp->penugasan_id;
        DB::table('laporan_lampirans')->where('id', '=', $id)->delete();
        Session::flash('success', 'Lampiran Berhasil Dihapus!');
        return redirect('verifikasi/viewLaporan/' . $penugasan_id);
    }

    public function deleteLaporan($id)
    {
        DB::beginTransaction();
        try {
            $getLaporan = DB::table('laporans')->find($id);
            DB::table('laporan_details')->where('laporan_id', $id)->delete();
            DB::table('laporans')->where('id', $id)->delete();
            DB::commit();
            Session::flash('success', 'Laporan Berhasil Dihapus!');
            // all good
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi Kesalahan!');
            DB::rollback();
            // something went wrong
        }
        return redirect('verifikasi/viewLaporan/' . $getLaporan->penugasan_id);
    }

    public function getDataEdit()
    {
        $laporan_id = $_GET['laporan_id'];
        $laporan = DB::table('laporans')->find($laporan_id);
        return json_encode($laporan);
    }

    public function editDasarHukum(Request $request)
    {
        DB::table('laporans')->where('id', $request->laporan_id)->update(['dasar_hukum' => $request->dasar_hukum]);
        $laporan = DB::table('laporans')->find($request->laporan_id);

        Session::flash('success', 'Dasar Hukum Berhasil Diubah!');
        return redirect('verifikasi/viewLaporan/' . $laporan->penugasan_id);
    }

    public function simpan_self(Request $request)
    {
        $id = $request->penugasan_id;
        if ($request->check_self != "on") {
            $request->nilai_self = 0;
        }
        $dataUpdate = array(
            'check_self' => $request->check_self,
            'nilai_self' => $request->nilai_self,
            'jml_vendor' => $request->jml_vendor,
            'jml_bahan_baku' => $request->jml_bahan_baku,
        );
        DB::table('penugasans')->where('id', $id)->update($dataUpdate);

        return redirect('verifikasi/mulai/' . $id);
    }
}
