<?php

namespace App\Models;

use App\Enum\CategoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    public function casts(): array
    {
        return [
            'status' => CategoryStatus::class,
        ];
    }
}
