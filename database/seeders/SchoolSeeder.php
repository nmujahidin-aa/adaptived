<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            [
                'id' => '1',
                'name' => 'SMA Negeri 1 Kepanjen',
                'address' => 'Jl. Raya Kepanjen No.1, Malang',
                'phone' => '0341-123456',
                'email' => 'info@sman1kepanjen.sch.id',
                'website' => 'http://sman1kepanjen.sch.id',
                'logo' => 'logos/sman1.png',
                'status' => 'active',
            ],
            [
                'id' => '2',
                'name' => 'SMA Negeri 2 Kepanjen',
                'address' => 'Jl. Raya Kepanjen No.2, Malang',
                'phone' => '0341-654321',
                'email' => 'info@sman2kepanjen.sch.id',
                'website' => 'http://sman2kepanjen.sch.id',
                'logo' => 'logos/sman2.png',
                'status' => 'active',
            ],
        ];

        foreach ($schools as $row) {
            \App\Models\School::create($row);
        }
    }
}
