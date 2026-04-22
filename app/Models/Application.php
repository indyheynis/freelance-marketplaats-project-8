<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'commissions_id',
        'user_id',
        'message',
        'status',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
