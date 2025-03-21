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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
     * {@inheritdoc}
     */
    protected $with = ['media'];

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
        if ($this->hasAnyRole([Acl::ROLE_SUPER_ADMIN, Acl::ROLE_ADMIN])) {
            return UserType::ADMIN->value;
        }

        if ($this->hasAnyRole([Acl::ROLE_ORGANIZATION])) {
            return UserType::ORGANIZATION->value;
        }

        if ($this->hasAnyRole([Acl::ROLE_INDIVIDUAL])) {
            return UserType::INDIVIDUAL->value;
        }

        return UserType::USER->value;
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
     * Get the sum of all donations across projects.
     *
     * @return float
     */
    public function getProjectsDonationsSumAmountAttribute(): float
    {
        $sum = 0;
        foreach ($this->projects as $project) {
            $sum += $project->donations->sum('amount');
        }
        return $sum;
    }
}
