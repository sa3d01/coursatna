<?php

use Illuminate\Database\Seeder;
use App\Models\Subject;
class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::create([
            'name_en' => 'math',
            'name_ar' => 'رياضيات',
        ]);
        Subject::create([
            'name_en' => 'arabic',
            'name_ar' => 'لغة عربية',
        ]);
        Subject::create([
            'name_en' => 'chemistry',
            'name_ar' => 'كيمياء ',
        ]);
        Subject::create([
            'name_en' => 'english',
            'name_ar' => 'لغة انجليزية',
        ]);
        $class_stages=[
            [
                'name_ar' => "الصف الأول",
                'name_en' => "first class",
            ],
            [
                'name_ar' => "الصف الثانى",
                'name_en' => "second class",
            ],
            [
                'name_ar' => "الصف الثالث",
                'name_en' => "third class",
            ],
        ];
        $stages=[
            [
                'name_ar' => " المرحلة الإعدادية",
                'name_en' => "middle School",
            ],
            [
                'name_ar' => "المرحلة الثانوية",
                'name_en' => "High school",
            ]
        ];
        $levels = [
            [
                'class_stage_id' => 1,
                'stage_id' => 1,
                'subjects' => '[1,2]',
            ],[
                'class_stage_id' => 2,
                'stage_id' => 1,
                'subjects' => '[1,2]',
            ],[
                'class_stage_id' => 3,
                'stage_id' => 1,
                'subjects' => '[1,2,4]',
            ],[
                'class_stage_id' => 1,
                'stage_id' => 2,
                'subjects' => '[1,2,4]',
            ],[
                'class_stage_id' => 2,
                'stage_id' => 2,
                'subjects' => '[1,3,4]',
            ],[
                'class_stage_id' => 3,
                'stage_id' => 2,
                'subjects' => '[1,2,3,4]',
            ],

        ];
        foreach ($class_stages as $class_stage) {
            DB::table('class_stages')->updateOrInsert($class_stage);
        }
        foreach ($stages as $stage) {
            DB::table('stages')->updateOrInsert($stage);
        }
        foreach ($levels as $level) {
            DB::table('levels')->updateOrInsert($level);
        }
//        $this->seedRows($rows);
    }

//    private function seedRows($rows)
//    {
//        foreach ($rows as $row) {
//            DB::table('levels')->updateOrInsert($row);
//        }
//    }
}
