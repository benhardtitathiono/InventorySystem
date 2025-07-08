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
        return $this->belongsToMany(Batch::class, 'detail_batch_product', 'batch_product_id','batch_product_product_abis_pakai_id')->withPivot('quantity_out', 'tanggal');
    }

    public function productWithTrashed()
    {
        return $this->belongsToMany(Batch::class, 'detail_batch_product', 'batch_product_id','batch_product_product_abis_pakai_id')
            ->withPivot('simpan_quantity_in', 'quantity_out', 'tanggal')->withTrashed();
    }
    public function batchList()
    {
        return $this->hasMany(Batch::class, 'product_abis_pakai_id');
    }
}

