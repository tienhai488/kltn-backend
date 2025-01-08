<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumOptions
{
    /**
     * Helper trait using for returning options
     */
    public static function options(bool $isObject = false): array
    {
        $cases = static::cases();
        $options = [];
        foreach ($cases as $case) {
            $options[] = $isObject ?
                (object) [
                    'value' => $case->value,
                    'label' => method_exists($case, 'getLabel') ? $case->getLabel() : $case->name,
                ]
                : [
                    'value' => $case->value,
                    'label' => method_exists($case, 'getLabel') ? $case->getLabel() : $case->name,
                ];
        }

        return $options;
    }
}