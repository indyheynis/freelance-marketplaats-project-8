<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'title',
        'description',
        'amount',
        'budget',
        'status',
        'deadline',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
