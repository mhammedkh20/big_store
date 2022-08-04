<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreImages extends Model
{
    use HasFactory;

    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
}
