<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Point extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'user_id',
        'city_id',
        'street',
        'place_detail',
        'location_latitude',
        'location_longitude',
        'name',
        'phone',
    ];

    protected $hidden =[
        'deleted_at'
    ];

    public $timestamps = true;

    public function orders()
    {
        return $this->hasMany(Order::class, 'point_id', 'id');
    }

    //belongs
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
