<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Loggable
{
    /**
     * Get all of the model's logs.
     */
    public function logs(): MorphMany
    {
        return $this->MorphMany(Log::class, 'loggable');
    }
}
