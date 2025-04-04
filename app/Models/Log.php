<?php

namespace App\Models;

use App\Enum\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'response',
        'status',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'status' => PaymentStatus::class,
    ];
}