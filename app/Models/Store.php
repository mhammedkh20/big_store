<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    // has relation
    public function staffs()
    {
        return $this->hasMany(Staff::class, 'store_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'store_id', 'id');
    }

    public function managers()
    {
        return $this->hasMany(Manager::class, 'store_id', 'id');
    }

    public function imagesStore()
    {
        return $this->hasMany(StoreImages::class, 'store_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }

    // belongs
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
