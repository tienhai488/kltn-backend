<?php

namespace App\Models;

use App\Enum\AccountRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationAccountRequest extends Model
{
    use HasFactory;

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
}