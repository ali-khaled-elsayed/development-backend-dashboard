<?php

namespace App\Modules\Shared\Enums;

enum UnitTypeEnum: string
{
    case Retails = 'retails';
    case Clinics = 'clinics';
    case Offices = 'offices';
    case Studios = 'studios';
    case Apartments = 'apartments';
    case Duplexes = 'duplexes';
    case Penthouses = 'Penthouses';
    case one_Bedroom = '1 Bedroom';
    case two_Bedrooms = '2 bedrooms';
    case three_Bedrooms = '3 Bedrooms';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function count(): int
    {
        return count(self::cases());
    }

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }

    public function label(): string
    {
        return match ($this) {
            self::one_Bedroom => '1 Bedroom',
            self::two_Bedrooms => '2 Bedrooms',
            self::three_Bedrooms => '3 Bedrooms',
            default => ucfirst(str_replace('_', ' ', $this->name)),
        };
    }
}
