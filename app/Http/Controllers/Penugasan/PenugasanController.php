<?php

namespace App\Http\Controllers\Penugasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use URL;
use App\Models\KonfirmasiOrder;
use App\Models\KonfirmasiOrderProduk;
use App\Models\Pembayaran;
use App\Models\User;
use Auth;
// use Spatie\Permission\Models\Role;

class PenugasanController extends Controller
{

    public function index()
    {
        return view('penugasan.index');
    }

    public function getData()
    {
        $status = $_GET['status'];
        $data = [];
        $query = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_diverifikasi')
            ->leftJoin('penugasans as p', 'ko.id', '=', 'p.oc_id')
            ->select(array('ko.id', 'ko.nomor', 'ko.objek_order', 'ko.berbayar', DB::raw('CONCAT(COALESCE(mp.badan,"")," ",mp.nama,"<small>(",COALESCE(mp.alamat_pabrik,""),")</small>") as nama'),    DB::raw('sum(p.jml_produk) as jml_produk')))
            ->groupBy('ko.id')
            ->orderBy('ko.id', 'DESC')
            ->get();

        $arrBerbayar = array("0" => "Tidak Berbayar", "1" => "Berbayar");
        $no = 1;
        for ($i = 0; $i < count($query); $i++) {
            if ($status == 1 && $query[$i]->objek_order > $query[$i]->jml_produk) {
                $row["no"] = '<center>' . ($no++) . '</center>';
                $row["id"] = $query[$i]->id;
                $row["nama"] = ' <a href="' . URL::to('penugasan/detail/' . $query[$i]->id) . '" >' . $query[$i]->nama . '</a>';
                $row["no_oc"] = '<center>' . $query[$i]->nomor . '</center>';
                $row["berbayar"] = '<center>' . $arrBerbayar[$query[$i]->berbayar] . '</center>';
                $row["objek_order"] = '<center><b>' . $query[$i]->objek_order . '</b></center>';
                if ($query[$i]->jml_produk == "") {
                    $row["jml_produk"] = '<center><b>0</b></center>';
                } else {
                    $row["jml_produk"] = '<center><b>' . $query[$i]->jml_produk . '</b></center>';
                }
                $data[] = $row;
            } elseif ($status == 2) {
                $row["no"] = '<center>' . ($no++) . '</center>';
                $row["id"] = $query[$i]->id;
                $row["nama"] = ' <a href="' . URL::to('penugasan/detail/' . $query[$i]->id) . '" >' . $query[$i]->nama . '</a>';
                $row["no_oc"] = '<center>' . $query[$i]->nomor . '</center>';
                $row["berbayar"] = '<center>' . $arrBerbayar[$query[$i]->berbayar] . '</center>';
                $row["objek_order"] = '<center><b>' . $query[$i]->objek_order . '</b></center>';
                if ($query[$i]->jml_produk == "") {
                    $row["jml_produk"] = '<center><b>0</b></center>';
                } else {
                    $row["jml_produk"] = '<center><b>' . $query[$i]->jml_produk . '</b></center>';
                }
                $data[] = $row;
            }
        }
        return response()->json($data, 200);
    }

    public function detail($id)
    {
        $oc = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_diverifikasi')
            ->select('ko.*', DB::raw('CONCAT(COALESCE(mp.badan,"")," ",mp.nama,"<small>(",COALESCE(mp.alamat_pabrik,""),")</small>") as nama'), 'mp.alamat_pusat', 'mp.alamat_pabrik')
            ->where('ko.id', '=', $id)
            ->get();
        $verifikator = User::role('Verifikator')->orderBy('users.name')->get();
        $etc = User::role('ETC')->orderBy('users.name')->get();

        $produk = KonfirmasiOrderProduk::where('oc_id', '=', $id)->get();
        $pembayaran = Pembayaran::where('oc_id', '=', $id)->get();
        return view('penugasan.detail')->with(compact('id', 'oc', 'produk', 'pembayaran', 'verifikator', 'etc'));
    }

    public function getSurtug($id)
    {
        $data = [];
        $penugasan = DB::table('penugasans as p')
            ->leftjoin('master_permens as mp', 'mp.kode_permen', '=', 'p.permen_id')
            ->leftjoin('master_perusahaan_alamat as mpa', 'mpa.id', '=', 'p.alamat_id')
            ->leftjoin('users as u1', 'u1.id', '=', 'p.verifikator1')
            ->leftjoin('users as u2', 'u2.id', '=', 'p.verifikator2')
            ->leftjoin('users as u3', 'u3.id', '=', 'p.verifikator3')
            ->leftjoin('users as u4', 'u4.id', '=', 'p.verifikator4')
            ->leftjoin('users as u5', 'u5.id', '=', 'p.verifikator5')
            ->leftjoin('users as uetc', 'uetc.id', '=', 'p.etc')
            ->leftjoin('users as upm', 'upm.id', '=', 'p.pm')
            ->where('p.oc_id', '=', $id)
            ->select('p.*', 'mp.nama_permen', 'u1.name as v1', 'u2.name as v2', 'u3.name as v3', 'u4.name as v4', 'u5.name as v5', 'uetc.name as uetc', 'upm.name as upm')
            ->get();

        if (count($penugasan) > 0) {
            $ver = '<ol style="padding-left:20px">';
            $e = $ver;
            foreach ($penugasan as $idx => $penugasan) {
                $tgl_mulai = implode("/", array_reverse(explode("-", $penugasan->tgl_mulai)));
                $tgl_akhir = implode("/", array_reverse(explode("-", $penugasan->tgl_akhir)));
                $row["no"] = ($idx + 1);
                $row["id"] = $penugasan->id;
                $row["tgl_mulai"] = $tgl_mulai;
                $row["no_ref"] = $penugasan->no_ref;
                $row["tgl_akhir"] = $tgl_akhir;
                $row["jml_produk"] = '<center>' . $penugasan->jml_produk . '</center>';
                if ($penugasan->upm != "") {
                    $row["pm"] = $penugasan->upm;
                } else {
                    $row["pm"] = "-";
                }
                if ($penugasan->uetc != "") {
                    $row["etc"] = $penugasan->uetc;
                } else {
                    $row["etc"] = "-";
                }

                $v = "<ol style='padding-left:20px'>";
                if ($penugasan->v1 != "") {
                    $v .= "<li>";
                    $v .= $penugasan->v1;
                    $v .= "</li>";
                }
                if ($penugasan->v2 != "") {
                    $v .= "<li>";
                    $v .= $penugasan->v2;
                    $v .= "</li>";
                }
                if ($penugasan->v3 != "") {
                    $v .= "<li>";
                    $v .= $penugasan->v3;
                    $v .= "</li>";
                }
                if ($penugasan->v4 != "") {
                    $v .= "<li>";
                    $v .= $penugasan->v4;
                    $v .= "</li>";
                }
                if ($penugasan->v5 != "") {
                    $v .= "<li>";
                    $v .= $penugasan->v5;
                    $v .= "</li>";
                }
                $v .= "</ol>";
                if ($penugasan->v1 != "") {
                    $row["verif"] = $v;
                } else {
                    $row["verif"] = "-";
                }

                $row["action"] = '<div class="btn-group">
                                <a href="' . URL::to('penugasan/edit/' . $penugasan->id . '/' . $penugasan->oc_id) . '" class="btn btn-sm btn-warning"><i class="fa fa-pencil mr-2"></i>Edit</a>
                                <a href="#" onclick="klikDelete(formdel' . $penugasan->id . ')" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash mr-2"></i>Delete
                                </a>
                                <form id="formdel' . $penugasan->id . '" method="POST" action="' . URL::to('penugasan/delete/' . $penugasan->id . '/' . $penugasan->oc_id) . '">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                               </div>';

                $data[] = $row;
            }
        }

        return response()->json($data, 200);
    }

    public function createSurtug(Request $request)
    {
        // $tgl_surtug = implode('-', array_reverse(explode("/", $request->tgl_surtug)));
        $tgl_mulai = implode('-', array_reverse(explode("/", $request->tgl_mulai)));
        $tgl_akhir = implode('-', array_reverse(explode("/", $request->tgl_akhir)));

        // get OC
        $oc = DB::table('konfirmasi_orders')->find($request->oc_id);
        $berbayar = $oc->berbayar;
        if ($berbayar == 1) {
            $tipe = "TKDN";
        } else {
            $tipe = "PTKDN";
        }
        $tahun = date('y');
        $no_ref = DB::table('master_sequence')->where('menu', 'ref')->where('tipe', $tipe)->where('tahun', $tahun)->get();
        if (!isset($no_ref[0])) {
            $nomor = 1;
            $nomor = sprintf("%05d", $nomor);
            DB::table('master_sequence')->insert(['menu' => 'ref', 'tipe' => $tipe, 'tahun' => $tahun, 'nomor' => $nomor]);
        } else {
            $nomor = $no_ref[0]->nomor + 1;
            $nomor = sprintf("%05d", $nomor);
            DB::table('master_sequence')
                ->where('menu', 'ref')
                ->where('tipe', $tipe)
                ->where('tahun', $tahun)
                ->update(['nomor' => $nomor]);
        }
        $no_ref = $tipe . ' - ' . $tahun . $nomor;
        $dataPenugas = array(
            'oc_id' => $request->oc_id,
            // 'tgl_surtug' => $tgl_surtug, 
            // 'no_surat' => $request->no_surat,
            'no_ref' => $no_ref,
            'tgl_mulai' => $tgl_mulai,
            'tgl_mulai' => $tgl_mulai,
            'tgl_akhir' => $tgl_akhir,
            'perusahaan_id' => $request->perusahaan_id,
            'jml_produk' => $request->jml_produk,
            'pm' => Auth::user()->id,
            'etc' => $request->etc,
            'verifikator1' => $request->verifikator[0],
            'verifikator2' => @$request->verifikator[1],
            'verifikator3' => @$request->verifikator[2],
            'verifikator4' => @$request->verifikator[3],
            'verifikator5' => @$request->verifikator[4],
        );
        $penugasan_id = DB::table('penugasans')->insertGetId($dataPenugas);

        // simpan produk
        $getProduk = DB::table('konfirmasi_order_produks')->where('oc_id', $request->oc_id)->get();
        for ($i = 0; $i < $request->jml_produk; $i++) {
            $dataVerProd = array(
                'penugasan_id' => $penugasan_id,
                'jenis_produk' => $getProduk[$i]->nama_produk,
                'tipe' => $getProduk[$i]->tipe_produk,
                'spesifikasi' => $getProduk[$i]->spesifikasi_produk,
            );
            DB::table('verifikasi_produks')->insert($dataVerProd);
        }

        return redirect('penugasan/detail/' . $request->oc_id);
    }

    public function delete($id, $oc_id)
    {
        $cekProdukVerified = DB::table('verifikasi_produks')->where('penugasan_id', $id)->whereNotNull('capaian_tkdn')->get();
        $totalProdukVerified = count($cekProdukVerified);
        if ($totalProdukVerified > 0) {
            $status = 'error';
            $pesan = 'Produk telah diverifikasi. Tidak bisa dihapus. Mohon untuk menghapus file excel verifikasi terlebih dahulu.';
        } else {
            DB::table('penugasans')->where('id', '=', $id)->delete();

            $getDel = DB::table('verifikasi_produks')->where('penugasan_id', $id)->get(array('id'));
            foreach ($getDel as $value) {
                DB::table('verifikasi_produks')->where('id', $value->id)->delete();
            }

            $status = 'success';
            $pesan = 'Data Penugasan Berhasil Dihapus!';
        }
        return redirect('penugasan/detail/' . $oc_id)->with($status, $pesan);
    }

    public function edit($id)
    {
        $penugasan = DB::table('penugasans as p')
            ->leftjoin('master_permens as mp', 'mp.kode_permen', '=', 'p.permen_id')
            ->leftjoin('users as u1', 'u1.id', '=', 'p.verifikator1')
            ->leftjoin('users as u2', 'u2.id', '=', 'p.verifikator2')
            ->leftjoin('users as u3', 'u3.id', '=', 'p.verifikator3')
            ->leftjoin('users as u4', 'u4.id', '=', 'p.verifikator4')
            ->leftjoin('users as u5', 'u5.id', '=', 'p.verifikator5')
            ->leftjoin('users as uetc', 'uetc.id', '=', 'p.etc')
            ->leftjoin('users as upm', 'upm.id', '=', 'p.pm')
            ->where('p.id', '=', $id)
            ->select('p.*', 'mp.nama_permen', 'u1.name as v1', 'u2.name as v2', 'u3.name as v3', 'u4.name as v4', 'u5.name as v5', 'uetc.name as uetc', 'upm.name as upm')
            ->get();

        $oc = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_diverifikasi')
            ->select('ko.*', 'mp.nama', 'mp.alamat_pusat', 'mp.alamat_pabrik')
            ->where('ko.id', '=', $penugasan[0]->oc_id)
            ->get();
        // dd($penugasan);

        $verifikator = User::role('Verifikator')->orderBy('users.name')->get();

        $etc = User::role('ETC')->orderBy('users.name')->get();

        return view('penugasan.edit')->with(compact('id', 'penugasan', 'verifikator', 'etc', 'oc'));
    }

    public function update(Request $request, $id)
    {
        $tgl_mulai = implode('-', array_reverse(explode("/", $request->tgl_mulai)));
        $tgl_akhir = implode('-', array_reverse(explode("/", $request->tgl_akhir)));

        $cekProduk = DB::table('verifikasi_produks')->where('penugasan_id', $id)->get();
        $totalProduk = count($cekProduk);
        $cekProdukVerified = DB::table('verifikasi_produks')->where('penugasan_id', $id)->whereNotNull('capaian_tkdn')->get();
        $totalProdukVerified = count($cekProdukVerified);

        $jumlahEdit = $request->jml_produk;

        $dataUpdate = array(
            'tgl_mulai' => $tgl_mulai,
            'tgl_akhir' => $tgl_akhir,
            'etc' => $request->etc,
            'jml_produk' => $jumlahEdit,
            'verifikator1' => $request->verifikator[0],
            'verifikator2' => @$request->verifikator[1],
            'verifikator3' => @$request->verifikator[2],
            'verifikator4' => @$request->verifikator[3],
            'verifikator5' => @$request->verifikator[4],
        );

        $status = 'success';
        $pesan = 'Data berhasil disimpan!';
        if ($jumlahEdit > $totalProduk) {
            $sisa = $jumlahEdit - $totalProduk;
            for ($i = 0; $i < $sisa; $i++) {
                DB::table('verifikasi_produks')
                    ->insert([
                        'penugasan_id' => $cekProduk[0]->penugasan_id,
                    ]);
            }
        } elseif ($jumlahEdit < $totalProduk) {
            $notVerified = $totalProduk - $totalProdukVerified;
            $jmlhHapus = $totalProduk - $jumlahEdit;
            if ($notVerified >= $jmlhHapus) {
                $getDel = DB::table('verifikasi_produks')->where('penugasan_id', $id)->whereNull('capaian_tkdn')->limit($jmlhHapus)->get(array('id'));
                foreach ($getDel as $value) {
                    DB::table('verifikasi_produks')->where('id', $value->id)->delete();
                }
            } else {
                $status = 'error';
                $pesan = 'Produk telah diverifikasi. Tidak bisa dihapus. Mohon untuk menghapus file excel verifikasi terlebih dahulu.';
            }
        }

        if ($status != "error") {
            DB::table('penugasans')
                ->where('id', '=', $id)
                ->update($dataUpdate);
        }
        return redirect('penugasan/detail/' . $request->oc_id)->with($status, $pesan);
    }
}
