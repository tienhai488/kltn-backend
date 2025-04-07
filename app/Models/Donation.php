<?php

namespace App\Models;

use App\Enum\ActiveStatus;
use App\Enum\AnonymousStatus;
use App\Enum\PaymentMethodCode;
use App\Enum\PaymentStatus;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory, Loggable;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'code',
        'status',
        'user_id',
        'project_id',
        'account_number',
        'account_name',
        'name',
        'email',
        'phone_number',
        'amount',
        'is_anonymous',
        'note',
        'department_id',
        'class',
        'student_code',
        'payment_method_code',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'status' => PaymentStatus::class,
        'is_anonymous' => AnonymousStatus::class,
        'payment_method_code' => PaymentMethodCode::class,
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