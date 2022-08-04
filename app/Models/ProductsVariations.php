<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsVariations extends Model
{
    use HasFactory;

    
    public function productsVariationOptions()
    {
        return $this->hasMany(ProductVariationsOptions::class, 'product_var_id', 'id');
    }

    // belongs
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
