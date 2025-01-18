<?php

namespace App\Models;

use App\Enum\AccountRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualAccountRequest extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'birth',
        'email',
        'phone_number',
        'club_name',
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
}
