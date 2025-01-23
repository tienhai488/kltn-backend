<?php

namespace App\Models;

use App\Enum\AnonymousStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'account_number',
        'account_name',
        'code',
        'name',
        'email',
        'phone_number',
        'amount',
        'is_anonymous',
        'note',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_anonymous' => AnonymousStatus::class,
    ];

    /**
     * Get the project that owns the donation.
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The user that made the donation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The department that the donation belongs to.
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}