<?php

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'id' => 1,
            'name_en' => 'Egypt',
            'name_ar' => 'مصر',
        ]);
    }
}
