<?php

namespace App\Models;

use App\Http\Controllers\PeminjamanController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    public function detailPinjam()
    {
        return $this->belongsToMany(
            PeminjamanController::class,
            'detail_peminjam ',
            'peminjaman_id',
            'product_pinjam_id'
        );
    }

    public function identitasPeminjam()
    {
        return $this->belongsTo(IdentitasPeminjam::class, 'identitas_peminjam_id');
    }
}
