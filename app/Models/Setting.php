<?php

namespace App\Models;

use App\Enum\SettingStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const IMAGE_COLLECTION = 'image';

    const IMAGES_COLLECTION = 'images';

    protected $fillable = [
        'key',
        'value',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'status' => SettingStatus::class,
    ];

    /**
     * Is enabled or not
     */
    protected function isEnabled(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->status == SettingStatus::ENABLED
        );
    }

    /**
     * Get the image URL.
     *
     * @return string
     */
    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getFirstMediaUrl(self::IMAGE_COLLECTION) ?: '',
        );
    }

    /**
     * Retrieve images associated with the model.
     *
     * @return Attribute
     */
    public function images(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMedia(self::IMAGES_COLLECTION) ?: [],
        );
    }
}
