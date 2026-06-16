<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'budget',
        'status',
        'deadline',
        'category_id',
        'user_id',
        'image',
        'latitude',
        'longitude',
        'location_name',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/'.$this->image);
        }

        return asset('images/commission-placeholder.svg');
    }

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function favoriteBY()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
