<?php

namespace App\Models;

use App\Enum\ActiveStatus;
use App\Enum\PaymentMethodCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'api_config',
        'icon_url',
        'sort_order',
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'code' => PaymentMethodCode::class,
        'api_config' => 'array',
        'status' => ActiveStatus::class,
    ];
}