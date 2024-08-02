<?php

namespace App\Http\Controllers;

use App\Models\BarangPinjam;
use App\Models\Peminjaman;
use App\Models\ProductAbisPakai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $tipe)
    {
        //
        // $pap = ProductAbisPakai::where('tipe', $tipe->get('kategori'))->orderBy('nama_barang')->get();
        // return view('peminjaman.barangKembali', ['pap' => $pap]);
        // $pap = Peminjaman::where('tipe', $tipe->get('kategori'))->orderBy('created_at')->get();
        $pinjam = DB::table('peminjaman as p')
            ->join('detail_peminjam as dp', 'p.id', '=', 'dp.peminjaman_id')
            ->join('barang_pinjam as bp', 'dp.product_pinjam_id', '=', 'bp.id')
            ->join('identitas_peminjam as ip', 'p.identitas_peminjam_id', '=', 'ip.id')
            ->where('bp.tipe', $tipe->kategori)
            ->groupBy('pinjamID', 'ip.nama', 'p.created_at', 'p.updated_at')
            ->select('p.id as pinjamID', 'ip.nama', 'p.created_at', 'p.updated_at')
            ->get();
        // dd($pinjam);
        return view('peminjaman.barangKembali', ['pinjam' => $pinjam]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
    function statuskembali(Request $request)
    {
        $idPinjam = $request->id;
        $peminjaman = Peminjaman::find($idPinjam);
        // dd($peminjaman->detailBarang);
        return response()->json(
            array(
                'status' => 'oke',
                'msg' => view('peminjaman.barangKembaliDetail', compact("peminjaman", "idPinjam"))->render()
            )
        );
    }
    function updatestatuskembali(Request $request)
    {
        // dd($request);

        $idPinjam = $request->query->keys();

        $peminjaman = Peminjaman::find($idPinjam);

        $tipeProd = '';
        if ($peminjaman) {
            for ($i = 1; $i < $request->totProd; $i++) {
                $prodID = $request->input('prodID' . $i);

                $tipeProd = BarangPinjam::find($prodID);
                $tipe = $tipeProd->tipe;
                $statKembali = $request->input('statKembali' . $i);

                // Update the pivot table data using DB query
                DB::table('detail_peminjam')  // replace with your actual pivot table name
                    ->where('peminjaman_id', $idPinjam)
                    ->where('product_pinjam_id', $prodID)
                    ->update([
                        'status_barang_kembali' => $statKembali,
                        'updated_at' => now()  // Update the timestamp
                    ]);
            }
            return redirect()->to('barangkembali?kategori=' . $tipe)->with('message', 'Sukses menyelesaikan pinjaman! Silahkan cek peminjaman untuk validasi');
        }
    }
}
