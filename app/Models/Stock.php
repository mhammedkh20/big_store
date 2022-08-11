<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'store_id',
        'stock_name'
    ];

    public $hidden = [
        'deleted_at'
    ];

    // belongs
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
