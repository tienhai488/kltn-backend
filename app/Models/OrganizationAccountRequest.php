<?php

namespace App\Models;

use App\Enum\AccountRequestStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrganizationAccountRequest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const RELATED_IMAGES = 'related_images';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'birth',
        'website',
        'field',
        'address',
        'username',
        'information',
        'representative_name',
        'representative_phone_number',
        'representative_email',
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
     * Get the related images for the organization account request.
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
