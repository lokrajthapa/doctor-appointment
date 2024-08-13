<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('departments')->insert([
            [
                'name' => 'Emergency Department (ER)',
            ],
            [
                'name' => 'Cardiology',
            ],
            [
                'name' => 'Neurology',
            ],
            [
                'name' => 'Oncology',
            ],
            [
                'name' => 'Orthopedics',
            ],
            [
                'name' => 'Radiology',
            ],
            [
                'name' => 'Surgery',
            ],
            [
              'name' => 'Anesthesiology',
            ],
            [
                'name' => 'Psychiatry',
            ],

        ]

        );
    }
}
