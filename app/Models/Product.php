<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


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
