<?php

namespace App\Models;

use App\Enum\Gender;
use App\Enum\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Vite;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, InteractsWithMedia;

    const USER_AVATAR_COLLECTION = 'user_avatar';
    const USER_AVATAR_RESIZE_NAME = 'avatar_resize';
    const CONVERSION_SIZE = [
        'width' => '650',
        'height' => '415',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => UserStatus::class,
        'birth_of_date' => 'datetime',
        'gender' => Gender::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar_url'];
    protected $with = ['media'];

    public function getAvatarUrlAttribute($value): bool|string
    {
        if (!$this->relationLoaded('media')) {
            return false;
        }

        $mediaUrl = $this->getFirstMediaUrl(self::USER_AVATAR_COLLECTION);

        return $mediaUrl ?: Vite::asset('resources/images/avatar-default.svg');
    }
}