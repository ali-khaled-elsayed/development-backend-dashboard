<?php

namespace App\Modules\Gallery\Enums;

enum MediaTypeEnum: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';

    public static function values(): array {

        return array_column(self::cases(), 'value');
    }
}
