<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dashboard Level
        Role::firstOrCreate(['name' => 'SUPER_ADMIN']);
        Role::firstOrCreate(['name' => 'ADMIN']);
        Role::firstOrCreate(['name' => 'SYS_MANAGER']);
        Role::firstOrCreate(['name' => 'SYS_EDITOR']);
        Role::firstOrCreate(['name' => 'SYS_SUPPORT']);
        // Mobile Level
        Role::firstOrCreate(['name' => 'UNIVERSITY_STUDENT']);
        Role::firstOrCreate(['name' => 'SCHOOL_STUDENT']);
        // Mutual Level
        Role::firstOrCreate(['name' => 'UNIVERSITY_HEAD_DOCTOR']);
        Role::firstOrCreate(['name' => 'UNIVERSITY_DOCTOR']);
        Role::firstOrCreate(['name' => 'UNIVERSITY_CREATOR_STUDENT']);
        Role::firstOrCreate(['name' => 'SCHOOL_TEACHER']);
        Role::firstOrCreate(['name' => 'TEACHER']);
    }
}
