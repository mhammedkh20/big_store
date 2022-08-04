<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;



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
