<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum ProjectFrontStatus: int
{
    use EnumValues, EnumOptions;

    case IN_PROGRESS = 1;
    case GOAL_ACHIEVED = 2;
    case FINISHED = 3;
    case PAUSED = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'Đang thực hiện',
            self::GOAL_ACHIEVED => 'Đạt mục tiêu',
            self::FINISHED => 'Đã kết thúc',
            self::PAUSED => 'Tạm dừng',
        };
    }
}