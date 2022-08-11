<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsVariations extends Model
{
    use HasFactory, SoftDeletes;

    public $with =[
        'productsVariationOptions'
    ];

    public $fillable = [
        'product_id',
        'variation_name'
    ];

    public $hidden = [
        'deleted_at'
    ];

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
