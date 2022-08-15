<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreImages extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'store_id',
        'image_url'
    ];

    public $hidden =[
        'deleted_at'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
