<?php

namespace App\Http\Controllers;

use App\Models\BarangPinjam;
use App\Models\IdentitasPeminjam;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangPinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $tipe)
    {
        //
        // dd($tipe);
        $bp = BarangPinjam::where('tipe', $tipe->get('kategori'))->orderBy('nama_barang')->get();
        foreach ($bp as $barang) {
            $barang->totalBarangDipinjam = $barang->detailPinjam()->sum('total_barang_dipinjam');
            if (!isset($barang->totalBarangDipinjam)) {
                $barang->totalBarangDipinjam = 0;
            }
        }
        // foreach ($bp as $barang) {
        //     dd($barang->totalBarangDipinjam);
        // }

        // dd($bp);
        return view('peminjaman.index', ['barangPinjam' => $bp]);
    }

    function indexdeleted($tipe)
    {
        // dd($tipe);
        $bp = BarangPinjam::onlyTrashed()->where('tipe', $tipe)->get();
        return response()->json(
            array(
                'status' => 'oke',
                'msg' => view('peminjaman.getDeleteBarangList', compact('bp'))->render()
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        do {
            $idBarang = Carbon::now(
                'Asia/Jakarta'
            )->format('Ymd') . rand(10, 99);
        } while (
            BarangPinjam::where('id', $idBarang)->exists()
        );

        $bp = new BarangPinjam();
        $bp->id = $idBarang;
        $bp->nama_barang = $request->get('nameBarang');
        $bp->deskripsi = $request->get('descBarang');
        $bp->jumlah = $request->get('jumlahBarang');
        $bp->created_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $bp->updated_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $bp->tipe = $request->get('tipeBarang');
        $bp->save();

        return redirect()->to('productpinjam?kategori=' . $bp->tipe)->with('message', 'Sukses Membuat Barang Baru! Silahkan cek barang ' . $request->get('nameBarang') . ' untuk validasi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $bp = BarangPinjam::find($id);
            $bp->delete();
            $bp->deleted_at = Carbon::now(
                'Asia/Jakarta'
            )->format('Y-m-d H:i:s');
            $bp->updated_at = Carbon::now(
                'Asia/Jakarta'
            )->format('Y-m-d H:i:s');
            return redirect()->to('productpinjam?kategori=' . $bp->tipe)->with('message', 'Barang ' . $bp->nama_barang . ' berhasil dihapus');
        } catch (\PDOException $error) {
            $msg = "Data gagal dihapus. pastikan kembali tidak ada data yang terhubung sebelum dihapus";
            return redirect()->to('productpinjam?kategori=' . $bp->tipe)->with('message', $msg);
        }
    }

    public function restore($id)
    {
        $bp = BarangPinjam::withTrashed()->find($id);
        if ($bp) {
            $bp->restore();
            $bp->updated_at
                = Carbon::now(
                    'Asia/Jakarta'
                )->format('Y-m-d H:i:s');
            // dd($pap);
            return redirect()->back()->with('message', 'Barang dengan id ' . $bp->id . " - " . $bp->nama_barang . ' berhasil dipulihkan');
        } else {
            return redirect()->back()->with('message', 'Barang tidak ditemukan');
        }
    }

    public function getBorrowForm(Request $tipe)
    {
    }

    function borrowProduct(Request $request)
    {
        $session_idIdentity = $request->get('idIdentity');
        $idIdentity = $request->get('identityPinjam');

        if ($session_idIdentity != $idIdentity) {
            return redirect()->back()->withErrors(['error' => 'Identitas tidak ditemukan']);
        } else {
            $totProdBorrow = $request->get('totProdBorrow');
            $tipeProd = '';
            $pinjam = new Peminjaman();
            do {
                $idPinjam = (int)Carbon::now('Asia/Jakarta')->format('Ymd') . rand(10, 99);
                $pinjam->id = $idPinjam;
            } while ($pinjam::where('id', $idPinjam)->exists());
            $pinjam->identitas_peminjam_id = $idIdentity;
            $pinjam->created_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
            $pinjam->updated_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
            $pinjam->save();
            for ($i = 0; $i < $totProdBorrow; $i++) {
                $id = $request->get('idProd' . ($i > 0 ? $i : ''));
                $jumlah = $request->get('stokProdQuan' . ($i > 0 ? $i : ''));
                $bp = BarangPinjam::find($id);
                $tipeProd = $bp->tipe;
                $totProduk = $bp->jumlah - $bp->detailPinjam()->sum('total_barang_dipinjam');
                if ($totProduk >= $jumlah or $totProduk <= 0) {
                    $pinjam->detailBarang()->attach($id, [
                        "created_at" => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                        "updated_at" => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                        "total_barang_dipinjam" => $jumlah,
                    ]);
                } else {
                    return redirect()->back()->with('message', 'Gagal Meminjam Barang! Stok barang ' . $bp->nama_barang . ' kurang dari yang akan dipinjam ');
                }
                var_dump(Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'));
                // dd($pinjam);
            }
            return redirect()->to('barangkembali?kategori=' . $tipeProd)->with('message', 'Sukses Meminjam Barang! Silahkan cek barang untuk validasi');
            // return redirect()->to('barangkembali?kategori='$)->with('message', 'Sukses Meminjam Barang! Silahkan cek barang untuk validasi');
        }
    }
}
