<?php

use Illuminate\Database\Seeder;
use App\Models\Governorate;

class GovernoratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Governorate::create(['country_id' => 1, 'name_en' => 'Cairo', 'name_ar' => 'القاهرة']);
        Governorate::create(['country_id' => 1, 'name_en' => 'Giza', 'name_ar' => 'الجيزة']);
        Governorate::create(['country_id' => 1, 'name_en' => 'Alexandria', 'name_ar' => 'الأسكندرية']);
        Governorate::create(['country_id' => 1, 'name_en' => 'Dakahlia', 'name_ar' => 'الدقهلية']);
    }
}
