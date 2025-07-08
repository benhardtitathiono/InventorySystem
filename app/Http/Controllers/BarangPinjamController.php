<?php

namespace App\Http\Controllers;

use App\Models\BarangPinjam;
use App\Models\IdentitasPeminjam;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



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
        //dd($bp);

        foreach ($bp as $barang) {
            // Hitung total dipinjam dari detail_peminjam YANG BELUM DIKEMBALIKAN
            $terpinjam = DB::table('detail_peminjam')
                ->where('product_pinjam_id', $barang->id)
                ->where(function ($q) {
                    $q->whereNull('status_barang_kembali')
                    ->orWhere('status_barang_kembali', 'terpinjam');
                })
                ->sum('total_barang_dipinjam');

            $barang->stok_terpinjam = $terpinjam;
            $barang->stok_tersedia = $barang->jumlah - $terpinjam;
        }
        //dd($barang->stok_tersedia);
        return view('peminjaman.index', ['barangPinjam' => $bp]);


        // foreach ($bp as $barang) {
        //     $barang->totalBarangDipinjam = $barang->detailPinjam()->sum('total_barang_dipinjam');
        //     if (!isset($barang->totalBarangDipinjam)) {
        //         $barang->totalBarangDipinjam = 0;
        //     }
        // }
        // foreach ($bp as $barang) {
        //     dd($barang->totalBarangDipinjam);
        // }

        // return view('peminjaman.index', ['barangPinjam' => $bp]);
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
        // dd($tipe->query('kategori'));
        $idPeminjam = IdentitasPeminjam::all();
        // $barangPinjam = BarangPinjam::where('tipe', $tipe->query('kategori'))->orderBy('nama_barang')->get();
        $barangPinjam = BarangPinjam::withCount([
            'detailPinjam as totalBarangDipinjam' => function ($q) {
                $q->select(DB::raw('COALESCE(SUM(total_barang_dipinjam), 0)'));
            }
        ])
        ->where('tipe', $tipe->query('kategori'))
        ->orderBy('nama_barang')
        ->get();
        return view('peminjaman.getBorrowform', ['barangPinjam' => $barangPinjam, 'idPeminjam' => $idPeminjam]);
    }

    function borrowProduct(Request $request)
    {
        // $session_idIdentity = $request->get('idIdentity');

        $idIdentity = $request->get('identityPinjam');
        $totProdBorrow = $request->get('totProdBorrow');
        $stats = $request->get('statPinjam');
        // dd($stats);
        $tipeProd = '';

        do {
            $idPinjam = (int)Carbon::now('Asia/Jakarta')->format('Ymd') . rand(10, 99);
        } 
        while (DB::table('peminjaman')->where('id', $idPinjam)->exists());

            $idProd = $request->get('idProd');
            $jumlahPinjam = $request->get('stokProdQuan');
            

            // Ambil data barang
            $bp = DB::table('barang_pinjam')->where('id', $idProd)->first();
            if (!$bp) {
                return redirect()->back()->with('message', 'Barang dengan ID ' . $id . ' tidak ditemukan!');
            }

            $tipeProd = $bp->tipe;

            // Hitung stok tersedia
            $totalBarang = DB::table('barang_pinjam')->where('id', $idProd)->value('jumlah');

            $barangTersedia = $totalBarang - $jumlahPinjam;
            // dd($totalBarang, $barangTersedia);

            if ($barangTersedia >= $jumlahPinjam && $jumlahPinjam > 0) {
                DB::table('peminjaman')->insert([
                'id' => $idPinjam,
                'identitas_peminjam_id' => $idIdentity,
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);

                DB::table('detail_peminjam')->insert([
                    'id'=>$idPinjam,
                    'product_pinjam_id' => $idProd,
                    'peminjaman_id' => $idPinjam,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                    'updated_at' => Carbon::now('Asia/Jakarta'),
                    'total_barang_dipinjam' => $jumlahPinjam,
                    'status_barang_kembali' => $stats
                ]);
            } else {
                return redirect()->to('barangkembali?kategori=' . $tipeProd)->with('message', 'Gagal meminjam! Stok barang "' . $bp->nama_barang . '" tidak mencukupi.');
            }

        return redirect()->to('barangkembali?kategori=' . $tipeProd)
            ->with('message', 'Sukses Meminjam Barang! Silahkan cek barang untuk validasi.');
    }
    function laporanbulananpinjam(){
        $laporan = DB::table('detail_peminjam')
        ->join('barang_pinjam', 'detail_peminjam.product_pinjam_id', '=', 'barang_pinjam.id')
        ->select(
            'barang_pinjam.id as id_barang',
            'barang_pinjam.nama_barang',
            DB::raw('SUM(detail_peminjam.total_barang_dipinjam) as total_dipinjam'),
            DB::raw("DATE_FORMAT(detail_peminjam.created_at, '%M %Y') as bulan")
        )
        ->groupBy(
            'barang_pinjam.id',
            'barang_pinjam.nama_barang',
            DB::raw("DATE_FORMAT(detail_peminjam.created_at, '%M %Y')")
        )
        ->orderByDesc(DB::raw("YEAR(detail_peminjam.created_at)"))
        ->orderByDesc(DB::raw("MONTH(detail_peminjam.created_at)"))
        ->get();
        return view('riwayat.monthlyreportbarangpinjam', compact('laporan'));
    }
}
