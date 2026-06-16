<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Application;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        return $this->hasMany(Favorite::class);
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

    public function favorites()
    {
        return $this->belongsToMany(Commission::class, 'favorites');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
