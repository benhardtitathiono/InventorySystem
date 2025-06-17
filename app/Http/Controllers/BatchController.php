<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $tipe)
    {
        //
        $bp = DB::table('batch_product as bp')
            ->join('detail_batch_product as dbp', 'bp.id', '=', 'dbp.batch_product_id')
            ->join('product_abis_pakai as pap', 'bp.product_abis_pakai_id', '=', 'pap.id')
            ->where('pap.tipe', $tipe->get('kategori'))
            ->whereNull('pap.deleted_at')
            ->orderBy('bp.id')
            ->orderBy('bp.tanggal_kadaluarsa')
            ->select('bp.id', 'pap.nama_barang', 'bp.tanggal_masuk', 'bp.tanggal_kadaluarsa', 'bp.jumlah')
            ->get();
        // dd($bp);
        return view('batch.index', ['bp' => $bp]);
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
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        //
    }
}
