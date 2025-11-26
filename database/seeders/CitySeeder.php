<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name_en' => 'Cairo',       'name_ar' => 'القاهرة'],
            ['name_en' => 'Giza',        'name_ar' => 'الجيزة'],
            ['name_en' => 'Alexandria',  'name_ar' => 'الإسكندرية'],
            ['name_en' => 'Mansoura',    'name_ar' => 'المنصورة'],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate($city);
        }
    }
}
