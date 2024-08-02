<?php

namespace App\Models;

use App\Http\Controllers\BarangPinjamController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangPinjam extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'barang_pinjam';

    protected $fillable = ['nama_barang', 'jumlah', 'deskripsi'];

    public function detailPinjam(): BelongsToMany
    {
        return $this->belongsToMany(
            Peminjaman::class,
            'detail_peminjam',
            'product_pinjam_id',
            'peminjaman_id'
        )->withPivot('created_at', 'updated_at', 'total_barang_dipinjam', 'status_barang_kembali');
    }
}
