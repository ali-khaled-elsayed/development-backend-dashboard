<?php

namespace App\Modules\User\Enums;

enum UserTypeEnum: string
{
    case Admin = 'admin';
    case Client = 'client';
    case Developer = 'developer';
    case Broker = 'broker';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
