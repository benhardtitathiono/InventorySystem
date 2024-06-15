<?php

use App\Http\Controllers\ProductAbisPakaiController;
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
route::get('/productabispakaiterhapus', [ProductAbisPakaiController::class, 'indexdeleted'])->name('product.getDeleteProductList');
Route::post('/productbaru', [ProductAbisPakaiController::class, "store"])->name('product.store');
Route::post('productabispakai/updatestok', [ProductAbisPakaiController::class, 'getUpdateStokForm'])->name('product.getUpdateStokForm');
Route::post('/updateStock', [ProductAbisPakaiController::class, "updateStock"])->name('product.updateStock');
Route::post('productabispakai/updatestokout', [ProductAbisPakaiController::class, 'getUpdateStokOutForm'])->name('product.getUpdateStokOutForm');
Route::post('/updateStockOut', [ProductAbisPakaiController::class, "updateStockOut"])->name('product.updateStockOut');
Route::post('/productabispakai/delete/{id}', [ProductAbisPakaiController::class, "destroy"])->name('product.destroy');
Route::post('/productabispakai/undelete/{id}', [ProductAbisPakaiController::class, "restore"])->name('product.restore');
