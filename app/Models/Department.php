<?php

namespace App\Models;

use App\Enum\DepartmentStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Department extends Model implements HasMedia
{
    use InteractsWithMedia;

    const DEPARTMENT_THUMBNAIL_COLLECTION = 'department_thumbnail';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'status' => DepartmentStatus::class,
    ];

    /**
     * {@inheritdoc}
     */
    protected $appends = ['thumbnail_url'];

    /**
     * Get the thumbnail url attribute.
     *
     * @return bool|string
     */
    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            fn() => $this->getFirstMediaUrl(self::DEPARTMENT_THUMBNAIL_COLLECTION) ?: Vite::asset('resources/images/no-image.jpg')
        );
    }
}
