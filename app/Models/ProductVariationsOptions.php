<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariationsOptions extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'product_var_id',
        'variation_option',
        'add_price',
    ];

    public $hidden = [
        'deleted_at',
    ];

    public function productsVariation()
    {
        return $this->belongsTo(ProductVariationsOptions::class, 'product_var_id', 'id');
    }
}
