<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'title',
        'description',
        'budget',
        'status',
        'deadline',
        'category_id',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

<<<<<<< HEAD
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
=======

>>>>>>> 42bd56317ce9b61fd04b1968ae811f3393d9a569
}
