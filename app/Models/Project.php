<?php

namespace App\Models;

use App\Enum\ProjectStatus;
use App\Enum\ProjectType;
use App\Enum\VolunteerStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Vite;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const PROJECT_BACKGROUND_IMAGE = 'project_background_image';

    const PROJECT_RELATED_IMAGES = 'project_related_images';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'donation_target',
        'volunteer_quantity',
        'start_date',
        'end_date',
        'content',
        'status',
        'type',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => ProjectStatus::class,
        'type' => ProjectType::class
    ];

    /**
     * {@inheritdoc}
     */
    protected $appends = ['background_image', 'related_images'];

    /**
     * {@inheritdoc}
     */
    protected $with = ['media'];

    /**
     * {@inheritdoc}
     */
    public function media(): MorphMany
    {
        return $this->morphMany(config('media-library.media_model'), 'model');
    }

    /**
     * Get the background image associated with the project.
     *
     * @return Attribute<string, never, mixed>
     */
    public function backgroundImage(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl(self::PROJECT_BACKGROUND_IMAGE) ?: Vite::asset('resources/images/no-image.jpg'),
        );
    }

    /**
     * Retrieve related images for the project.
     *
     * @return Attribute
     */
    public function relatedImages(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMedia(self::PROJECT_RELATED_IMAGES) ?? [],
        );
    }

    /**
     * Get the category associated with the project.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the project.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the donations associated with the project.
     *
     * @return HasMany
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the volunteers associated with the project.
     *
     * @return HasMany
     */
    public function volunteers(): HasMany
    {
        return $this->hasMany(Volunteer::class);
    }

    /**
     * Get the volunteers associated with the project that are not canceled.
     *
     * @return HasMany
     */
    public function volunteers_without_canceled(): HasMany
    {
        return $this->hasMany(Volunteer::class)
            ->where('status', '!=', VolunteerStatus::CANCELED->value);
    }
}
