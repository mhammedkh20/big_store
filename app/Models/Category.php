<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'category_name',
        'category_icon',
        'parent_id'
    ];


    public $hidden = [
        'deleted_at'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function categoriesParent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function categoryChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
