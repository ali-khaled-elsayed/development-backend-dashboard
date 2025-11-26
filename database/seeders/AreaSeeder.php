<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['name_en' => 'Nasr City',   'name_ar' => 'مدينة نصر',     'city' => 'Cairo'],
            ['name_en' => 'Heliopolis',  'name_ar' => 'مصر الجديدة',   'city' => 'Cairo'],
            ['name_en' => 'Mohandessin', 'name_ar' => 'المهندسين',     'city' => 'Giza'],
            ['name_en' => 'Agouza',      'name_ar' => 'العجوزة',       'city' => 'Giza'],
            ['name_en' => 'Sidi Gaber',  'name_ar' => 'سيدي جابر',     'city' => 'Alexandria'],
        ];

        foreach ($areas as $area) {
            $cityId = City::where('name_en', $area['city'])->first()->id;

            Area::firstOrCreate([
                'name_en' => $area['name_en'],
                'name_ar' => $area['name_ar'],
                'city_id' => $cityId,
            ]);
        }
    }
}
