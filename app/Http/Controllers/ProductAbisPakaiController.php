<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ProductAbisPakai;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $pap = ProductAbisPakai::all();
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
        $idProd = Carbon::now(
            'Asia/Jakarta'
        )->format('is');
        $pap = new ProductAbisPakai();
        $pap->id = $idProd;
        $pap->nama_barang = $request->get('nameProd');
        $pap->satuan = $request->get('satuanProd');
        $pap->deskripsi = $request->get('descProd');
        $pap->jumlah = $request->get('jumlahProd');
        $pap->nama_barang = $request->get('jumlahProd');
        $pap->created_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $pap->updated_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $pap->save();

        $idBatch = $idProd . (int)Carbon::now('Asia/Jakarta')->format('YmdHis');
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

        return redirect()->route('product.index')->with('message', 'Sukses membuat Produk Baru! Silahkan cek produk ' . $$request->get('nameProd') . ' untuk validasi');
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
}
