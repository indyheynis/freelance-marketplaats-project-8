<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperCommission
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property numeric|null $budget
 * @property string $status
 * @property string|null $deadline
 * @property int $category_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $image
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string|null $location_name
 * @property-read Collection<int, Application> $applications
 * @property-read int|null $applications_count
 * @property-read Category $category
 * @property-read Collection<int, User> $favoritedBy
 * @property-read int|null $favorited_by_count
 * @property-read string $image_url
 * @property-read Invoice|null $invoice
 * @property-read Collection<int, Message> $messages
 * @property-read int|null $messages_count
 * @property-read Collection<int, Offer> $offers
 * @property-read int|null $offers_count
 * @property-read Collection<int, Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read User $user
 *
 * @method static \Database\Factories\CommissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commission whereUserId($value)
 * @method bool|null delete()
 * @method bool update(array $attributes = [], array $options = [])
 *
 * @mixin \Eloquent
 */
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

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isInvolvedUser(int $userId): bool
    {
        if ($this->user_id === $userId) {
            return true;
        }

        return $this->applications()->where('user_id', $userId)->where('status', 'accepted')->exists();
    }
}
