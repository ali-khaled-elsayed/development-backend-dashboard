<?php

namespace App\Modules\Project\Enums;

enum FinishingTypeEnum: string
{
    case Final_Touch = 'Final Touch';
    // case Commercial = 'commercial';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
