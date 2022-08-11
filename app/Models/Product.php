<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'category_id',
        'store_id',
        'brand_id',
        'product_name',
        'product_describtion',
        'price',
        'discount',
    ];


    public $hidden = [
        'deleted_at'
    ];

    public function productVariationOptions()
    {
        return $this->hasOneThrough(
            ProductVariationsOptions::class,
            ProductsVariations::class,
            'product_id',
            'product_var_id',
        );
    }

    public function productsVariations()
    {
        return $this->hasMany(ProductsVariations::class, 'product_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    public function orderItem()
    {
        return $this->hasOne(OrderItems::class, 'product_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id', 'id');
    }

    // belongs
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
