<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdentitasPeminjam extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'identitas_peminjam';

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
