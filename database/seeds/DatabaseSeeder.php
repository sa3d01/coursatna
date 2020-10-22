<?php

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Item;
use App\Models\Course;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(LevelsTableSeeder::class);
//
//        /**
//         * Seeds for Testing
//         */
//
//        $this->call(CountriesTableSeeder::class);
//        $this->call(GovernoratesTableSeeder::class);
//        $this->call(CitiesTableSeeder::class);
//
//
//        //      $this->call(ItemsTableSeeder::class);
//        Course::create([
//            'name'=>'النحو والصرف',
//            'teacher_id'=>2,
//            'subject_id'=>2,
//            'level_id'=>2,
//            'price'=>350,
//        ]);
//        Course::create([
//            'name'=>'verb to be',
//            'teacher_id'=>3,
//            'subject_id'=>4,
//            'level_id'=>1,
//            'price'=>250,
//        ]);
//        \App\Models\CourseSession::create([
//            'topic'=>'الحصة الأولى مقدمة',
//            'uploader_id'=>2,
//            'course_id'=>1,
//            'open'=>true
//        ]);
//        \App\Models\CourseSession::create([
//            'topic'=>'الحصة الثانية ',
//            'uploader_id'=>2,
//            'course_id'=>1,
//        ]);
//        \App\Models\CourseSession::create([
//            'topic'=>'الحصة الثالثة ',
//            'uploader_id'=>2,
//            'course_id'=>1,
//        ]);
//        \App\Models\CourseSession::create([
//            'topic'=>'الحصة الأولى مقدمة',
//            'uploader_id'=>3,
//            'course_id'=>2,
//            'open'=>true
//        ]);
//        \App\Models\CourseSession::create([
//            'topic'=>'الحصة الثانية ',
//            'uploader_id'=>3,
//            'course_id'=>2,
//        ]);
//        \App\Models\CourseSession::create([
//            'topic'=>'الحصة الثالثة ',
//            'uploader_id'=>3,
//            'course_id'=>2,
//        ]);
        \App\Models\Setting::create([
            'logo'=>'logo.png',
            'about_ar'=>'about',
            'about_en'=>'about',
            'terms_ar'=>'terms',
            'terms_en'=>'terms',
        ]);
        /**
         * Required Seeds
         */
//
//        $this->call(RolesTableSeeder::class);
//        $this->call(PermissionsTableSeeder::class);
//
//        $this->call(UsersTableSeeder::class);
//        $this->call(DummyUsersTableSeeder::class);
    }
}
