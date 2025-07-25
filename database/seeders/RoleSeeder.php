<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'SUPERADMIN',
        ],[
            'name' => 'SUPERADMIN',
            'guard_name' => 'web'
        ]);

        Role::firstOrCreate([
            'name' => 'ADMINISTRATOR',
        ],[
            'name' => 'ADMINISTRATOR',
            'guard_name' => 'web'
        ]);

        Role::firstOrCreate([
            'name' => 'TEACHER',
        ],[
            'name' => 'TEACHER',
            'guard_name' => 'web'
        ]);

        Role::firstOrCreate([
            'name' => 'STUDENTS',
        ],[
            'name' => 'STUDENTS',
            'guard_name' => 'web'
        ]);
    }
}
