<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\RoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Create a default user with ADMINISTRATOR role
        $Administrator = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ],[
            'email' => 'admin@gmail.com',
            'name' => 'ADMINISTRATOR',
            'phone' => '08123456789',
            'password' => bcrypt('password'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $Administrator->assignRole(RoleEnum::ADMINISTRATOR);

        // Create a default user with TEACHER role
        $Teacher = User::firstOrCreate([
            'email' => 'teacher@gmail.com'
        ],[
            'email' => 'teacher@gmail.com',
            'name' => 'TEACHER',
            'phone' => '08123456789',
            'school_id' => 1,
            'gender' => 'L',
            'password' => bcrypt('password'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $Teacher->assignRole(RoleEnum::TEACHER);

        // Create a default user with STUDENTS role
        $Student = User::firstOrCreate([
            'email' => 'student@gmail.com'
        ],[
            'email' => 'student@gmail.com',
            'name' => 'STUDENT',
            'phone' => '08123456789',
            'school_id' => 1,
            'gender' => 'L',
            'password' => bcrypt('password'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $Student->assignRole(RoleEnum::STUDENT);
    }
}
