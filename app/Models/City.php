<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    
    public $hidden = [
        'deleted_at',
    ];

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'city_id', 'id');
    }

    public function location()
    {
        return $this->hasMany(Point::class, 'city_id', 'id');
    }

    public function store()
    {
        return $this->hasMany(Store::class, 'city_id', 'id');
    }
}
