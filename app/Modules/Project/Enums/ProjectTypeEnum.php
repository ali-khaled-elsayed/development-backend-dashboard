<?php

namespace App\Modules\Project\Enums;

enum ProjectTypeEnum: string
{
    case Residential = 'residential';
    case Commercial = 'commercial';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return [
            self::Residential->value => 'Residential',
            self::Commercial->value => 'Commercial',
        ];
    }
}
