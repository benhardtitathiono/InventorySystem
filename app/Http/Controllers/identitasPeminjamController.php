<?php

namespace App\Http\Controllers;

use App\Models\IdentitasPeminjam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IdentitasPeminjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $identity = IdentitasPeminjam::orderBy('nama')->get();
        return view('identitas_peminjam.index', ['identity' => $identity]);
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
        do {
            $idIdentitas = Carbon::now(
                'Asia/Jakarta'
            )->format('Ymd') . rand(10, 99);
        } while (
            IdentitasPeminjam::where('id', $idIdentitas)->exists()
        );

        $identity = new IdentitasPeminjam();
        $identity->id = $idIdentitas;
        $identity->nama = $request->get('nameIdentitas');
        $identity->created_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $identity->updated_at = Carbon::now(
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        $identity->save();

        return redirect()->route('identitas.index')->with('message', 'Sukses Membuat Identitas Baru! Silahkan cek identitas ' . $request->get('nameProd') . ' untuk validasi');
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
            $identity = IdentitasPeminjam::find($id);
            $identity->delete();
            $identity->deleted_at = Carbon::now(
                'Asia/Jakarta'
            )->format('Y-m-d H:i:s');
            $identity->updated_at = Carbon::now(
                'Asia/Jakarta'
            )->format('Y-m-d H:i:s');
            return redirect()->route('identitas.index')->with('message', 'Identitas ' . $identity->nama . ' berhasil dihapus');
        } catch (\PDOException $error) {
            $msg = "Data gagal dihapus. pastikan kembali tidak ada data yang terhubung sebelum dihapus";
            return redirect()->route('identitas.index')->with('message', $msg);
        }
    }

    function identitasdeleted()
    {
        $identity = IdentitasPeminjam::onlyTrashed()->get();
        return response()->json(
            array(
                'status' => 'oke',
                'msg' => view('identitas_peminjam.getDeleteIdentitasList', compact('identity'))->render()
            )
        );
    }

    public function restore($id)
    {
        $identity = IdentitasPeminjam::withTrashed()->find($id);
        if ($identity) {
            $identity->restore();
            $identity->update_at
                = Carbon::now(
                    'Asia/Jakarta'
                )->format('Y-m-d H:i:s');
            // dd($pap);
            return redirect()->route('identitas.index')->with('message', 'Identitas dengan id ' . $identity->id . " - " . $identity->nama . ' berhasil dipulihkan');
        } else {
            return redirect()->route('identitas.index')->with('message', 'Identitas tidak ditemukan');
        }
    }

    function getLogIdentitasPeminjam(Request $request)
    {
    }
}
