<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $fillable = [
    'user_id',
    'commission_id',
    'price',
    'message',
];
    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
