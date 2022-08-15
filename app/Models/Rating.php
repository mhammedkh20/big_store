<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'product_id',
        'order_id',
        'user_id',
        'rating',
    ];

    public $hidden = [
        'deleted_at'
    ];


    public function comments()
    {
        return $this->hasMany(Comment::class, 'rating_id', 'id');
    }

    // belongs
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
