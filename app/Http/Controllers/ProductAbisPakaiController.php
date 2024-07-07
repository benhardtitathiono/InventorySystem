<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ProductAbisPakai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductAbisPakaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pap = ProductAbisPakai::orderBy('nama_barang')->get();
        return view('product.index', ['pap' => $pap]);
    }

    function indexdeleted()
    {
        $pap = ProductAbisPakai::onlyTrashed()->get();
        return response()->json(
            array(
                'status' => 'oke',
                'msg' => view('product.getDeleteProductList', compact('pap'))->render()
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
        // dd($request);
        $idProd = Carbon::now(
            'Asia/Jakarta'
        )->format('Ymd') . rand(10, 99);
        $pap = new ProductAbisPakai();
        $pap->id = $idProd;
        $pap->nama_barang = $request->get('nameProduct');
        $pap->satuan = $request->get('satuanProd');
        $pap->deskripsi = $request->get('descProd');
        $pap->jumlah = $request->get('jumlahProd');
        $pap->created_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $pap->updated_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $pap->save();

        $idBatch = $idProd . (int)Carbon::now('Asia/Jakarta')->format('Ymd');
        $b = new Batch();
        $b->id = $idBatch;
        $b->tanggal_masuk = Carbon::now()->format('Y-m-d');
        $b->tanggal_kadaluwarsa = $request->get('dateExProd');
        $b->jumlah = $request->get('jumlahProd');
        $b->save();

        $b->logBatch()->attach($idProd, [
            "quantity_in" => $request->get('jumlahProd'),
            "tanggal" => Carbon::now()->format('Y-m-d')
        ]);
        $b->save();

        return redirect()->route('product.index')->with('message', 'Sukses membuat Produk Baru! Silahkan cek produk ' . $request->get('nameProd') . ' untuk validasi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductAbisPakai  $ProductAbisPakai
     * @return \Illuminate\Http\Response
     */
    public function show(ProductAbisPakai $ProductAbisPakai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductAbisPakai  $ProductAbisPakai
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductAbisPakai $ProductAbisPakai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductAbisPakai  $ProductAbisPakai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductAbisPakai $ProductAbisPakai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductAbisPakai  $ProductAbisPakai
     * @return \Illuminate\Http\Response
     */
    public function destroy($ProductAbisPakai)
    {
        //
        try {
            $pap = ProductAbisPakai::find($ProductAbisPakai);
            $pap->delete();
            $pap->deleted_at = Carbon::now(
                'Asia/Jakarta'
            )->format('Y-m-d H:i:s');
            return redirect()->route('product.index')->with('message', 'Produk ' . $pap->nama_barang . ' berhasil dihapus');
        } catch (\PDOException $error) {
            $msg = "Data gagal dihapus. pastikan kembali tidak ada data yang berelasi sebelum dihapus";
            return redirect()->route('product.index')->with('message', $msg);
        }
    }

    public function restore($id)
    {
        $pap = ProductAbisPakai::withTrashed()->find($id);
        if ($pap) {
            $pap->restore();
            // dd($pap);
            return redirect()->route('product.index')->with('message', 'Produk dengan id ' . $pap->id . " - " . $pap->nama_barang . ' berhasil dipulihkan');
        } else {
            return redirect()->route('product.index')->with('message', 'Produk tidak ditemukan');
        }
    }

    public function getUpdateStokForm(Request $request)
    {
        $id = $request->get('id');
        $pap = ProductAbisPakai::find($id);
        session()->flash('product_id', $pap->id);
        // dd($pap);
        return response()->json(
            array(
                'status' => 'oke',
                'msg' => view('product.getupdatestockform', compact('pap'))->render()
            )
        );
    }

    function updateStock(Request $request)
    {
        $b = new Batch();
        $session_id = session()->get('product_id');
        $id = $request->get('idProd');

        if ($id != $session_id) {
            return redirect()->back()->withErrors(['error' => 'Produk tidak ditemukan']);
        } else {
            $product = ProductAbisPakai::find($id);
            $name = $request->get('nameProd');
            $satuan = $request->get('satuanProd');
            $desc = $request->get('descProd');
            $jumlah = $request->get('stokProdQuan');
            $dateEx = $request->get('dateExProd');

            $product->fill(['nama_barang' => $name, 'deskripsi' => $desc, 'satuan' => $satuan]);
            if ($product->isDirty()) {
                $product->save();
            }
            $b->id = $id . (int)Carbon::now('Asia/Jakarta')->format('YmdHis');
            $b->tanggal_masuk = Carbon::now()->format('Y-m-d');
            $b->tanggal_kadaluwarsa = $dateEx;
            $b->jumlah = $jumlah;
            $b->save();

            $b->logBatch()->attach($id, [
                "quantity_in" => $jumlah,
                "tanggal" => Carbon::now()->format('Y-m-d')
            ]);
            $b->save();

            $product->jumlah += $jumlah;
            $product->updated_at = Carbon::now(
                'Asia/Jakarta'
            )->format('Y-m-d H:i:s');
            $product->save();
            return redirect()->back()->with('message', 'Sukses memperbaharui! Silahkan cek produk ' . $name . ' untuk validasi');
        }
    }

    public function getUpdateStokOutForm(Request $request)
    {
        $id = $request->get('id');
        $pap = ProductAbisPakai::find($id);
        session()->flash('product_id', $pap->id);
        // dd($pap->logBatch);
        return response()->json(
            array(
                'status' => 'oke',
                'msg' => view('product.getupdatestockoutform', compact('pap'))->render()
            )
        );
    }

    function updateStockOut(Request $request)
    {
        $session_id = session()->get('product_id');
        $id = $request->get('idProd');

        if ($id != $session_id) {
            return redirect()->back()->withErrors(['error' => 'Produk tidak ditemukan']);
        } else {
            $product = ProductAbisPakai::find($id);
            $name = $request->get('nameProd');
            $jumlah = $request->get('stokProdQuan');
            $noBatch = $request->get('batchProd');

            $b = Batch::find($noBatch);

            $b->jumlah -= $jumlah;
            $b->save();

            $b->logBatch()->attach($id, [
                "quantity_out" => $jumlah,
                "tanggal" => Carbon::now()->format('Y-m-d')
            ]);
            $b->save();

            $product->jumlah -= $jumlah;
            $product->updated_at = Carbon::now(
                'Asia/Jakarta'
            )->format('Y-m-d H:i:s');
            $product->save();
            $product->save();
            // dd($b);
            return redirect()->back()->with('message', 'Sukses memperbaharui! Silahkan cek produk ' . $name . ' untuk validasi');
        }
    }

    function logProduct(Request $request)
    {
        $id = $request->get('id');
        $logProduct = DB::table('product_abis_pakai as pap')
            ->join('log_product_batch as lpb', 'pap.id', '=', 'lpb.product_id')
            ->join('batch_product as bp', 'lpb.batch_product', '=', 'bp.id')
            ->where('pap.id', $id)
            ->orderBy('lpb.tanggal', 'desc')
            ->select('pap.id', 'pap.nama_barang', 'bp.id as batch_product', 'lpb.quantity_in', 'lpb.quantity_out', 'lpb.tanggal')
            ->get();
        // dd($logProduct);
        return response()->json(
            array(
                'status' => 'oke',
                'msg' => view('riwayat.logProduct', compact('logProduct'))->render()
            )
        );
    }

    public function laporanharianbap(Request $request)
    {
        //
        $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $reqDate = $request->get('dateReport');
        if (isset($reqDate)) {
            $date = $reqDate;
        }
        $logpap = DB::table('product_abis_pakai as pap')
            ->join('log_product_batch as lpb', 'pap.id', '=', 'lpb.product_id')
            ->where('lpb.tanggal', $date)
            ->groupBy('pap.id', 'pap.nama_barang', 'lpb.tanggal')
            ->select('pap.id', 'pap.nama_barang', DB::raw('sum(lpb.quantity_in) as totquanin'), DB::raw('sum(lpb.quantity_out) as totquanout'), 'lpb.tanggal')
            ->get();
        // dd($logpap);
        return view('riwayat.dailyreportbap', ['logpap' => $logpap, 'date' => $date]);
    }
}
