<?php

namespace App\Models;

use App\Enum\ActiveStatus;
use App\Enum\PaymentMethodCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Returns the URL of the icon of the payment method, if it has an icon.
     *
     * @return string|null
     */
    public function icon(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->icon_url ? asset($this->icon_url) : null,
        );
    }
}
