<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperApplication
 *
 * @property int $id
 * @property int $commission_id
 * @property int $user_id
 * @property string|null $message
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Commission $commission
 * @property-read User $freelancer
 *
 * @method static \Database\Factories\ApplicationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereUserId($value)
 * @method bool|null delete()
 * @method bool update(array $attributes = [], array $options = [])
 *
 * @mixin \Eloquent
 */
class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
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
