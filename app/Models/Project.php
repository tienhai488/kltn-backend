<?php

namespace App\Models;

use App\Enum\PaymentStatus;
use App\Enum\ProjectFrontStatus;
use App\Enum\ProjectStatus;
use App\Enum\ProjectType;
use App\Enum\VolunteerStatus;
use App\Observers\ProjectObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Vite;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy([ProjectObserver::class])]
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
        'slug',
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
        'type' => ProjectType::class,
    ];

    protected $with = [
        'media',
    ];

    /**
     * =====================================
     * Attributes
     * =====================================
     */

    /**
     * Get the status of the project on the frontend.
     *
     * @return ProjectFrontStatus|null
     */
    public function getFrontStatusAttribute(): ProjectFrontStatus|null
    {
        if ($this->status == ProjectStatus::PAUSED) {
            return ProjectFrontStatus::PAUSED;
        }

        if ($this->status == ProjectStatus::APPROVED) {
            if (now() > $this->end_date) {
                return ProjectFrontStatus::FINISHED;
            } else if (
                $this->donations_with_paid->sum('amount') >= $this->donation_target
                && $this->volunteers_without_canceled->count() >= $this->volunteer_quantity
            ) {
                return ProjectFrontStatus::GOAL_ACHIEVED;
            }

            return ProjectFrontStatus::IN_PROGRESS;
        }

        return null;
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

    public function totalAmount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->donations_with_paid()->sum('amount') ?? 0,
        );
    }

    public function volunteersCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->volunteers_without_canceled()->count() ?? 0,
        );
    }

    public function getTimePercentAttribute(): int
    {
        // If project is finished, return 100%
        if ($this->end_date < now()) {
            return 100;
        }

        // If project hasn't started yet, return 0%
        if ($this->start_date > now()) {
            return 0;
        }

        // Calculate percentage for ongoing projects
        $totalDuration = $this->end_date->diffInSeconds($this->start_date);
        $elapsedDuration = now()->diffInSeconds($this->start_date);

        // Avoid division by zero
        if ($totalDuration == 0) {
            return 0;
        }

        $percentage = round(($elapsedDuration / $totalDuration) * 100);

        return $percentage;
    }

    /**
     * =====================================
     * Relationships
     * =====================================
     */

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
     * Get the paid donations associated with the project.
     *
     * @return HasMany<Donation>
     */
    public function donations_with_paid(): HasMany
    {
        return $this->hasMany(Donation::class)
            ->where('status', PaymentStatus::PAID->value);
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
