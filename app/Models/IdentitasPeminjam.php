<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasPeminjam extends Model
{
    use HasFactory;

    protected $table = 'identitas_peminjam';

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
