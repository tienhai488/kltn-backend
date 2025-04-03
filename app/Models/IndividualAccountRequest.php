<?php

namespace App\Models;

use App\Enum\AccountRequestStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class IndividualAccountRequest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const RELATED_IMAGES = 'related_images';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'birth',
        'email',
        'phone_number',
        'club_name',
        'field',
        'website',
        'address',
        'information',
        'username',
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'birth' => 'datetime',
        'status' => AccountRequestStatus::class,
    ];

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'related_images',
    ];

    /**
     * Get the related images for the individual account request.
     *
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media[]
     */
    public function relatedImages(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMedia(self::RELATED_IMAGES) ?? [],
        );
    }
}
