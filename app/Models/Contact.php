<?php

namespace App\Models;

use App\Enum\ContactStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'status',
        'subject',
        'content',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'status' => ContactStatus::class,
    ];

    /**
     * Get the user that owns the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}