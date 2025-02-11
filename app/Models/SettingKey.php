<?php

namespace App\Models;

use App\Enum\SettingStatus;

class SettingKey
{
    const EXAMPLE = [
        'key' => 'example',
        'value' => 1,
        'status' => SettingStatus::ENABLED,
    ];

    const POLICY = [
        'key' => 'policy',
        'value' => '',
        'status' => SettingStatus::ENABLED,
    ];

    const TERMS = [
        'key' => 'terms',
        'value' => '',
        'status' => SettingStatus::ENABLED,
    ];

    public static function allKeys(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $keys = $class->getConstants();

            return array_values($keys);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    public static function keysName(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $keys = $class->getConstants();
            foreach ($keys as $item) {
                if (is_array($item) && array_key_exists("key", $item)) {
                    $resultArray[] = $item["key"];
                }
            }

            return array_values($resultArray);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }
}