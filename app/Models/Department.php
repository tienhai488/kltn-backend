<?php

namespace App\Models;

use App\Enum\DepartmentStatus;
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
    protected $with = ['media'];

    /**
     * Get the thumbnail url attribute.
     *
     * @return bool|string
     */
    public function getThumbnailUrlAttribute($value): bool|string
    {
        if (!$this->relationLoaded('media')) {
            return false;
        }

        return $this->getFirstMediaUrl(self::DEPARTMENT_THUMBNAIL_COLLECTION) ?: Vite::asset('resources/images/no-image.jpg');
    }
}
