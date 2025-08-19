<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssesmentVariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variables = [
            [
                'id' => 1,
                'icon' => 'bar-chart-line',
                'name' => 'Berpikir Kritis',
            ],
            [
                'id' => 2,
                'icon' => 'bar-chart-line',
                'name' => 'Kolaborasi',
            ],
            [
                'id' => 3,
                'icon' => 'bar-chart-line',
                'name' => 'Komunikasi',
            ],
            [
                'id' => 4,
                'icon' => 'bar-chart-line',
                'name' => 'Berpikir Kreatif',
            ],
            [
                'id' => 5,
                'icon' => 'bar-chart-line',
                'name' => 'Literasi Digital',
            ],
            [
                'id' => 6,
                'icon' => 'bar-chart-line',
                'name' => 'Literasi Kesehatan',
            ],
            [
                'id' => 7,
                'icon' => 'bar-chart-line',
                'name' => 'Literasi Lingkungan',
            ],
            [
                'id' => 8,
                'icon' => 'bar-chart-line',
                'name' => 'Literasi Biodiversitas',
            ],
        ];

        foreach ($variables as $row) {
            \App\Models\Variable::create($row);
        }
    }
}
