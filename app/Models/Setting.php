<?php

namespace App\Models;

use App\Enum\SettingStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'status',
    ];

    protected $table = 'settings';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'status' => SettingStatus::class,
    ];

    /**
     * Is enabled or not
     */
    protected function isEnabled(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->status == SettingStatus::ENABLED
        );
    }
}