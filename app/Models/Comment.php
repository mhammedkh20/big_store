<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    public $hidden = [
        'deleted_at'
    ];

    public $fillable = [
        'rating_id',
        'user_id',
        'comment'
    ];


    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
