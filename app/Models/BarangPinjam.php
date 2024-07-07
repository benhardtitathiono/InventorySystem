<?php

namespace App\Models;

use App\Http\Controllers\BarangPinjamController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangPinjam extends Model
{
    use HasFactory;

    protected $table = 'barang_pinjam';

    public function detailPinjam()
    {
        return $this->belongsToMany(
            BarangPinjamController::class,
            'detail_peminjam ',
            'product_pinjam_id',
            'peminjaman_id'
        );
    }
}
