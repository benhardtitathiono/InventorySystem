<?php

namespace App\Models;

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAbisPakai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_abis_pakai';

    protected $fillable = ['nama_barang', 'satuan', 'deskripsi'];

    public function logBatch()
    {
        return $this->belongsToMany(Batch::class, 'log_product_batch', 'product_id', 'batch_product')->withPivot('quantity_in', 'quantity_out', 'tanggal');
    }

    public function productWithTrashed()
    {
        return $this->belongsToMany(Batch::class, 'log_product_batch', 'product_id', 'batch_product')
            ->withPivot('quantity_in', 'quantity_out', 'tanggal')->withTrashed();
    }
}
