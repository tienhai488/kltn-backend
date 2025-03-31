<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum PriceRangeFilter: string
{
    use EnumValues, EnumOptions;

    case UNDER_200K = 'under_200k';
    case FROM_200K_TO_1M = 'from_200k_to_1m';
    case FROM_1M_TO_10M = 'from_1m_to_10m';
    case OVER_10M = 'over_10m';

    public function getLabel(): string
    {
        return match ($this) {
            self::UNDER_200K => '<= 200.000',
            self::FROM_200K_TO_1M => 'Từ 200.000 <= 1.000.000',
            self::FROM_1M_TO_10M => 'Từ 1.000.000 <= 10.000.000',
            self::OVER_10M => '>= 10.000.000',
        };
    }

    public static function getValues($value): array
    {
        return match ($value) {
            self::UNDER_200K->value => [0, 200000],
            self::FROM_200K_TO_1M->value => [200000, 1000000],
            self::FROM_1M_TO_10M->value => [1000000, 10000000],
            self::OVER_10M->value => [10000000, 9999999999],
        };
    }
}
