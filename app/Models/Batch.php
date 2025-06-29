<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'batch_product';

    public function logBatch()
    {
        return $this->belongsToMany(ProductAbisPakai::class, 'detail_batch_product', 'batch_product_id','batch_product_product_abis_pakai_id')->withPivot( 'quantity_in','quantity_out', 'tanggal');
    }
}
