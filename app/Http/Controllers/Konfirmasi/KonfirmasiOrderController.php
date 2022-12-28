<?php

namespace App\Http\Controllers\Konfirmasi;

use App\Http\Controllers\Controller;
use App\Models\KonfirmasiOrder;
use App\Models\KonfirmasiOrderProduk;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Auth;
use URL;
use DataTables;

class KonfirmasiOrderController extends Controller
{
    public function index()
    {
        return view('konfirmasi.index');
    }

    public function getList()
    {
        $role = Auth::user()->roles->pluck('name');
        $query = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_diverifikasi')
            ->select(array('ko.id', 'ko.nomor', 'ko.tanggal', 'ko.objek_order', 'ko.berbayar', DB::raw('CONCAT(COALESCE(mp.badan,"")," ",mp.nama,"<small>(",COALESCE(mp.alamat_pabrik,""),")</small>") as nama'), 'ko.status'))
            ->orderBy('ko.id', 'DESC')
            ->get();
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($q) {
                $tanggal = implode("/", array_reverse(explode("-", $q->tanggal)));
                return $tanggal;
            })
            ->editColumn('objek_order', function ($q) {
                $objek_order = '<center>' . $q->objek_order . '</center>';
                return $objek_order;
            })
            ->editColumn('berbayar', function ($q) {
                if ($q->berbayar == 0) {
                    $berbayar = "Tidak Berbayar";
                } else {
                    $berbayar = "Berbayar";
                }
                return $berbayar;
            })
            ->editColumn('status', function ($q) {
                if ($q->status == 0) {
                    $status = '<center><span class="badge badge-warning">Waiting Approval</span></center>';
                } else {
                    $status = '<center><span class="badge badge-success">Approved</span></center>';
                }
                return $status;
            })
            ->addColumn('action', function ($q) use ($role) {
                $action = '<div class="btn-group">
                                <a href="' . URL::to('konfirmasi-order/detail/' . $q->id) . '" class="btn btn-sm btn-info"><i class="fa fa-list mx-1"></i>Detail</a>';
                if ($q->status == 0 && ($role[0] <> 'Kabagpenjualan' || $role[0] <> 'PM')) {
                    $action .= '<a href="' . URL::to('konfirmasi-order/edit/' . $q->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-pencil mx-1"></i>Edit</a>
                                <a href="#" onclick="klikDelete(formdel' . $q->id . ')" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash mx-1"></i>Delete
                                </a>
                                <form id="formdel' . $q->id . '" method="POST" action="' . URL::to('konfirmasi-order/delete/' . $q->id) . '">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>';
                }

                if ($q->status == 0 && $role[0] === 'Marketing') {
                    $action .= '<a href="#" onclick="klikApprove(formapprove' . $q->id . ')" class="btn btn-sm btn-success">
                                <i class="fa fa-check mx-1"></i>Approve
                            </a>
                            <form id="formapprove' . $q->id . '" method="POST" action="' . URL::to('konfirmasi-order/approve/' . $q->id) . '">
                                ' . csrf_field() . '
                            </form>
                            </div>';
                }
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['nomor', 'tanggal', 'objek_order', 'nama', 'status', 'action'])
            ->make(true);
    }

    public function tambah()
    {
        $tgl_now = date("d/m/Y");
        $data = DB::table('master_perusahaans')->get();
        return view('konfirmasi.tambah')->with(compact('data', 'tgl_now'));
    }

    public function getdata($id)
    {
        $data = DB::table('master_perusahaans')->where('id', '=', $id)->get();

        return response()->json($data, 200);
    }

    public function post(Request $request)
    {
        $tanggal = implode('-', array_reverse(explode("/", $request->tanggal)));
        //insery konfirmasi order
        $p = new KonfirmasiOrder;
        $p->id_perusahaan_ditagihkan = $request->id_perusahaan_ditagihkan;
        $p->id_perusahaan_diverifikasi = $request->id_perusahaan_diverifikasi;
        $p->nomor = $request->nomor;
        $p->tanggal = $tanggal;
        $p->id_jenis_jasa = 1;
        $p->objek_order = $request->objek_order;
        $p->waktu_pelaksanaan = $request->waktu_pelaksanaan;
        $p->keterangan = $request->keterangan;
        $p->berbayar = $request->berbayar;
        $p->total_biaya = explode(',', str_replace('.', '', $request->total_biaya))[0];
        $p->dibebankan_kepada = $request->dibebankan_kepada;
        $p->referensi = $request->referensi;
        $p->save();
        $last_id = $p->id;

        //insert konfimasi order Produk
        $nama_produk = $request->nama_produk;
        $tipe_produk = $request->tipe_produk;
        $spesifikasi_produk = $request->spesifikasi_produk;
        for ($i = 0; $i < $request->objek_order; $i++) {
            $pd = new KonfirmasiOrderProduk;
            $pd->oc_id = $last_id;
            $pd->nama_produk = $nama_produk[$i];
            $pd->tipe_produk = $tipe_produk[$i];
            $pd->spesifikasi_produk = $spesifikasi_produk[$i];
            $pd->save();
        }

        if ($request->berbayar === 1) {
            //insert pembayaran
            $termin = $request->termin;
            $persentase = $request->persentase;
            $output = $request->output;
            foreach ($termin as $idx => $data) {
                $pp = new Pembayaran;
                $pp->oc_id = $last_id;
                $pp->termin = $termin[$idx];
                $pp->persentase = $persentase[$idx];
                $pp->output = $output[$idx];
                $pp->save();
            }
        }



        return redirect('konfirmasi-order');
    }

    public function edit($id)
    {
        $dataPerusahaan = KonfirmasiOrder::find($id);
        $alamat_tagihan = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_ditagihkan')
            ->select('mp.alamat_pusat')
            ->get();

        $alamat_verifikasi = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_diverifikasi')
            ->select('mp.alamat_pusat')
            ->get();

        $produk = DB::table('konfirmasi_order_produks')->where('oc_id', '=', $id)->get();
        $pembayaran = DB::table('pembayarans')->where('oc_id', '=', $id)->get();
        $perusahaan = DB::table('master_perusahaans')->get();
        $kelompok = DB::table('master_barang_jasa')->get();
        $data = DB::table('master_perusahaans')->get();
        return view('konfirmasi.edit')->with(compact('id', 'produk', 'dataPerusahaan', 'kelompok', 'perusahaan', 'data', 'alamat_tagihan', 'alamat_verifikasi', 'pembayaran'));
    }

    public function update($id, Request $request)
    {
        $update_oc = DB::table('konfirmasi_orders')
            ->where('id', $id)
            ->update([
                'id_perusahaan_ditagihkan' => $request->id_perusahaan_ditagihkan,
                'id_perusahaan_diverifikasi' => $request->id_perusahaan_diverifikasi,
                'id_jenis_jasa' => 1,
                'tanggal' => $request->tanggal,
                'nomor' => $request->nomor,
                'objek_order' => count($request->nama_produk),
                'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
                'berbayar' => $request->berbayar,
                'keterangan' => $request->keterangan,
                'total_biaya' => explode(',', str_replace('.', '', $request->total_biaya))[0],
                'dibebankan_kepada' => $request->dibebankan_kepada
            ]);

        if ($request->berbayar === 1) {
            $delete_pembayaran = DB::table('pembayarans')->where('oc_id', '=', $id)->delete();

            //insert pembayaran
            $termin = $request->termin;
            $persentase = $request->persentase;
            $output = $request->output;
            foreach ($termin as $idx => $data) {
                $pp = new Pembayaran;
                $pp->oc_id = $id;
                $pp->termin = $termin[$idx];
                $pp->persentase = $persentase[$idx];
                $pp->output = $output[$idx];
                $pp->save();
            }
        }

        $delete_produk = DB::table('konfirmasi_order_produks')->where('oc_id', '=', $id)->delete();

        //insert konfimasi order Produk
        $nama_produk = $request->nama_produk;
        $tipe_produk = $request->tipe_produk;
        $spesifikasi_produk = $request->spesifikasi_produk;
        foreach ($nama_produk as $idx => $data) {
            $pd = new KonfirmasiOrderProduk;
            $pd->oc_id = $id;
            $pd->nama_produk = $nama_produk[$idx];
            $pd->tipe_produk = $tipe_produk[$idx];
            $pd->spesifikasi_produk = $spesifikasi_produk[$idx];
            $pd->save();
        }

        return redirect('konfirmasi-order');
    }

    public function detail($id)
    {
        $dataPerusahaan = KonfirmasiOrder::find($id);
        $alamat_tagihan = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_ditagihkan')
            ->where('ko.id', $id)
            ->select('mp.nama', 'mp.alamat_pusat')
            ->get();

        $alamat_verifikasi = DB::table('konfirmasi_orders as ko')
            ->join('master_perusahaans as mp', 'mp.id', '=', 'ko.id_perusahaan_diverifikasi')
            ->where('ko.id', $id)
            ->select('mp.nama', 'mp.alamat_pusat')
            ->get();

        $produk = DB::table('konfirmasi_order_produks')->where('oc_id', '=', $id)->get();
        $pembayaran = DB::table('pembayarans')->where('oc_id', '=', $id)->get();
        $perusahaan = DB::table('master_perusahaans')->get();
        $kelompok = DB::table('master_barang_jasa')->get();
        $data = DB::table('master_perusahaans')->get();
        return view('konfirmasi.detail')->with(compact('id', 'produk', 'dataPerusahaan', 'kelompok', 'perusahaan', 'data', 'alamat_tagihan', 'alamat_verifikasi', 'pembayaran'));
    }

    public function delete($id)
    {
        $oc = KonfirmasiOrder::Find($id)->delete();
        $pembayaran = DB::table('pembayarans')->where('oc_id', '=', $id)->delete();
        $produk = DB::table('konfirmasi_order_produks')->where('oc_id', '=', $id)->delete();
        return redirect('konfirmasi-order')->with('status', 'Data berhasil dihapus!');;
    }

    public function approve($id)
    {
        $update_oc = DB::table('konfirmasi_orders')
            ->where('id', $id)
            ->update(['status' => 1, 'approved_by' => Auth::user()->name,'tanggal_approve' => date('Y-m-d H:i:s')]);
        return redirect('konfirmasi-order');
    }
}
