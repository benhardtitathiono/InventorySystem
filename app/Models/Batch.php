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
        return $this->belongsToMany(ProductAbisPakai::class, 'log_product_batch', 'batch_product', 'product_id')->withPivot('quantity_in', 'quantity_out', 'tanggal');
    }
}
