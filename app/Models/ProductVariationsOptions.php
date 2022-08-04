<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationsOptions extends Model
{
    use HasFactory;

    public function productsVariation()
    {
        return $this->belongsTo(ProductVariationsOptions::class, 'product_var_id', 'id');
    }
}
