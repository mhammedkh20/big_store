<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable =[
        'user_id',
        'point_id',
        'order_status',
        'total_price',
    ];

    public $hidden =[
        'deleted_at',
    ];


    public function rating()
    {
        return $this->hasOne(Rating::class, 'order_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    // belongs
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id', 'id');
    }
}
