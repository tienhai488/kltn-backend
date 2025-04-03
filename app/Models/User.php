<?php

namespace App\Models;

use App\Acl\Acl;
use App\Enum\Gender;
use App\Enum\UserStatus;
use App\Enum\UserType;
use App\Enum\VolunteerStatus;
use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, InteractsWithMedia;

    const USER_AVATAR_COLLECTION = 'user_avatar';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone_number',
        'birth_of_date',
        'password',
        'status',
        'gender',
        'address',
        'description',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => UserStatus::class,
        'birth_of_date' => 'datetime',
        'gender' => Gender::class,
    ];

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'avatar_url',
        'type',
    ];

    /**
     * Get the URL of the user's avatar.
     *
     * @return Attribute
     */
    public function avatarUrl(): Attribute
    {
        return Attribute::make(
            fn($value) => $this->getFirstMediaUrl(self::USER_AVATAR_COLLECTION) ?: Vite::asset('resources/images/avatar-default.svg')
        );
    }

    /**
     * Get the user type as a string.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return match (true) {
            $this->hasAnyRole([Acl::ROLE_SUPER_ADMIN, Acl::ROLE_ADMIN]) => UserType::ADMIN->value,
            $this->hasAnyRole([Acl::ROLE_ORGANIZATION]) => UserType::ORGANIZATION->value,
            $this->hasAnyRole([Acl::ROLE_INDIVIDUAL]) => UserType::INDIVIDUAL->value,
            default => UserType::USER->value,
        };
    }

    /**
     * Get the projects associated with the user.
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the donations associated with the user.
     *
     * @return HasMany
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the volunteers associated with the user.
     *
     * @return HasMany
     */
    public function volunteers(): HasMany
    {
        return $this->hasMany(Volunteer::class);
    }

    /**
     * Get the volunteers associated with the user that are not canceled.
     *
     * @return HasMany
     */
    public function volunteers_without_canceled(): HasMany
    {
        return $this->hasMany(Volunteer::class)
            ->where('status', '!=', VolunteerStatus::CANCELED->value);
    }

    /**
     * The sum of all donations of all projects created by the user.
     *
     * @return int
     */
    public function projectsDonationsSumAmount(): Attribute
    {
        return Attribute::make(
            fn($value) => $this->projects->sum(function ($project) {
                return $project->donations->sum('amount');
            })
        );
    }

    /**
     * Get the total count of all donations for all projects created by the user.
     *
     * @return Attribute
     */
    public function projectsDonationsCount(): Attribute
    {
        return Attribute::make(
            fn($value) => $this->projects->sum(function ($project) {
                return $project->donations->count();
            })
        );
    }
}
