<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@site.com',
            'password' => 123456,
            'type' => 'ADMIN',
        ]);
        $adminUser->assignRole(['ADMIN', 'SUPER_ADMIN']);

        $arabicTeacherUser = User::create([
            'name' => 'أستاذ محمد عادل',
            'email' => 'teacher@site.com',
            'password' => 123456,
            'type' => 'TEACHER',
        ]);
        $arabicTeacherUser->assignRole(['TEACHER', 'TEACHER']);

        $mathTeacherUser = User::create([
            'name' => 'أستاذ عادل شكل',
            'email' => 'ىشفا_teacher@site.com',
            'password' => 123456,
            'type' => 'TEACHER',
        ]);
        $mathTeacherUser->assignRole(['TEACHER', 'TEACHER']);

        /*
        $doctorUser = User::create([
            'name' => 'Doctor',
            'email' => 'doctor@site.com',
            'password' => 123456,
            'university_id' => 2,
            'faculty_id' => 2,
        ]);
        $doctorUser->assignRole(['UNIVERSITY_DOCTOR']);
        */
    }
}
