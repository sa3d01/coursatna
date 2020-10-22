<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'country_id' => 1,
            'governorate_id' => 1,
            'name_en' => 'Cairo',
            'name_ar' => 'القاهرة',
        ]);
        City::create([
            'country_id' => 1,
            'governorate_id' => 1,
            'name_en' => 'New Cairo',
            'name_ar' => 'نيو كايرو',
        ]);
        City::create([
            'country_id' => 1,
            'governorate_id' => 2,
            'name_en' => 'Giza',
            'name_ar' => 'الجيزة',
        ]);
        City::create([
            'country_id' => 1,
            'governorate_id' => 2,
            'name_en' => 'Six of October',
            'name_ar' => 'أكتوبر',
        ]);
        City::create([
            'country_id' => 1,
            'governorate_id' => 4,
            'name_en' => 'Mansoura',
            'name_ar' => 'المنصورة',
        ]);

    }
}
