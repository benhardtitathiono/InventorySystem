<?php

use App\Http\Controllers\BarangPinjamController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\IdentitasPeminjamController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProductAbisPakaiController;
use App\Models\Peminjaman;
use App\Models\ProductAbisPakai;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layout.halaman_utama_admin');
});

route::get('/productabispakai', [ProductAbisPakaiController::class, 'index'])->name('product.index');
Route::post('/productbaru', [ProductAbisPakaiController::class, "store"])->name('product.store');
Route::post('productabispakai/updatestok', [ProductAbisPakaiController::class, 'getUpdateStokForm'])->name('product.getUpdateStokForm');
Route::post('/updateStock', [ProductAbisPakaiController::class, "updateStock"])->name('product.updateStock');
Route::post('productabispakai/updatestokout', [ProductAbisPakaiController::class, 'getUpdateStokOutForm'])->name('product.getUpdateStokOutForm');
Route::post('/updateStockOut', [ProductAbisPakaiController::class, "updateStockOut"])->name('product.updateStockOut');
route::post('/productabispakaiterhapus/{tipe}', [ProductAbisPakaiController::class, 'indexdeleted'])->name('product.getDeleteProductList');
Route::post('/productabispakai/delete/{id}', [ProductAbisPakaiController::class, "destroy"])->name('product.destroy');
Route::post('/productabispakai/undelete/{id}', [ProductAbisPakaiController::class, "restore"])->name('product.restore');

route::get('/batchprod', [BatchController::class, 'index'])->name('batch.index');
// Route::post('/batchprod/delete/{id}', [BatchController::class, "destroy"])->name('batch.destroy');
// Route::post('/productabispakai/undelete/{id}', [BatchController::class, "restore"])->name('batch.restore');

Route::post('/logProduct', [ProductAbisPakaiController::class, 'logProduct'])->name('log.getLogProduct');
Route::post('/stokBatchProduct', [ProductAbisPakaiController::class, 'stokBatchProduct'])->name('log.getStokBatchProduct');
route::get('/laporanharianbarangabispakai', [ProductAbisPakaiController::class, 'laporanharianbap'])->name('log.logpap');
Route::post('/logBatch', [BatchController::class, 'logBatch'])->name('log.getLogBatchProduct');

route::get('/identitaspeminjam', [IdentitasPeminjamController::class, 'index'])->name('identitas.index');
Route::post('/identitaspeminjambaru', [IdentitasPeminjamController::class, "store"])->name('identitas.store');
route::get('/identitaspeminjamterhapus', [IdentitasPeminjamController::class, 'identitasdeleted'])->name('identitas.getDeleteIdentitasList');
Route::post('/identitaspeminjam/delete/{id}', [IdentitasPeminjamController::class, "destroy"])->name('identitas.destroy');
Route::post('/identitaspeminjam/undelete/{id}', [IdentitasPeminjamController::class, "restore"])->name('identitas.restore');

route::get('/productpinjam', [BarangPinjamController::class, 'index'])->name('productpinjam.index');
Route::post('/productpinjambaru', [BarangPinjamController::class, "store"])->name('productpinjam.store');
Route::post('productpinjam/pinjam', [BarangPinjamController::class, 'getBorrowForm'])->name('productpinjam.getBorrowForm');
Route::post('/pinjam', [BarangPinjamController::class, "borrowProduct"])->name('productpinjam.borrowProduct');
route::post('/productpinjamterhapus/{tipe}', [BarangPinjamController::class, 'indexdeleted'])->name('productpinjam.getDeleteBarangList');
Route::post('/productpinjam/delete/{id}', [BarangPinjamController::class, "destroy"])->name('productpinjam.destroy');
Route::post('/productpinjam/undelete/{id}', [BarangPinjamController::class, "restore"])->name('productpinjam.restore');

route::get('/barangkembali', [PeminjamanController::class, 'index'])->name('barangkembali.index');
route::post('/barangkembali/status', [PeminjamanController::class, 'statuskembali'])->name('barangkembali.status');
route::post('/barangkembali/updatestatus', [PeminjamanController::class, 'updatestatuskembali'])->name('barangkembali.updatestatus');
