<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperUser
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $address
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $phone_number
 * @property string $role
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $firstname
 * @property string|null $lastname
 * @property array<array-key, mixed>|null $skills
 * @property-read Collection<int, Application> $acceptedApplications
 * @property-read int|null $accepted_applications_count
 * @property-read Collection<int, Application> $applications
 * @property-read int|null $applications_count
 * @property-read Collection<int, Invoice> $clientInvoices
 * @property-read int|null $client_invoices_count
 * @property-read Collection<int, Commission> $commissions
 * @property-read int|null $commissions_count
 * @property-read Collection<int, Commission> $favoritedCommissions
 * @property-read int|null $favorited_commissions_count
 * @property-read Collection<int, Commission> $favorites
 * @property-read int|null $favorites_count
 * @property-read Collection<int, Invoice> $freelancerInvoices
 * @property-read int|null $freelancer_invoices_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Review> $receivedReviews
 * @property-read int|null $received_reviews_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'firstname',
    'lastname',
    'email',
    'role',
    'password',
    'skills',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'skills' => 'array',
        ];
    }

    public function isFreelancer(): bool
    {
        return $this->role === 'freelancer';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Commission::class, 'favorites');
    }

    public function favoritedCommissions()
    {
        return $this->belongsToMany(Commission::class, 'favorites');
    }

    public function clientInvoices()
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }

    public function freelancerInvoices()
    {
        return $this->hasMany(Invoice::class, 'freelancer_id');
    }

    public function acceptedApplications()
    {
        return $this->hasMany(Application::class)->where('status', 'accepted');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function averageRating(): ?float
    {
        $avg = $this->receivedReviews()->avg('rating');

        return $avg ? round($avg, 1) : null;
    }

    public function completedCommissionsCount(): int
    {
        return $this->acceptedApplications()->count();
    }

    public function averageCommissionDurationInDays(): ?float
    {
        $applications = $this->acceptedApplications()->with('commission')->get();

        if ($applications->isEmpty()) {
            return null;
        }

        $totalDays = $applications->sum(function (Application $application) {
            return $application->commission->created_at->diffInDays($application->commission->deadline);
        });

        return round($totalDays / $applications->count());
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
