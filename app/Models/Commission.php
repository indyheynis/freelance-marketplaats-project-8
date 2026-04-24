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

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
