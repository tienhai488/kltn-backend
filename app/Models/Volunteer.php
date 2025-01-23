<?php

namespace App\Models;

use App\Enum\VolunteerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Volunteer extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'department_id',
        'name',
        'email',
        'phone_number',
        'note',
        'student_code',
        'class',
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'status' => VolunteerStatus::class,
    ];

    /**
     * Get the user that owns the volunteer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project that owns the volunteer.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the department that the volunteer belongs to.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}