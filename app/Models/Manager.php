<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

     //has
     public function staffs()
     {
         return $this->hasMany(Staff::class, 'manager_id', 'id');
     }
 
     // belongs
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }
 
     public function store()
     {
         return $this->belongsTo(Store::class, 'store_id', 'id');
     }
}
