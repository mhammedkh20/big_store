<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class,'city_id','id');
    }

    public function location(){
        return $this->hasMany(Point::class,'city_id','id');
    }

    public function store(){
        return $this->hasMany(Store::class,'city_id','id');
    }
}
