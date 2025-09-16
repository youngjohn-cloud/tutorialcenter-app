<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [

            [
                'name' => 'JAMB (UTME)',
                'slug' => 'jamb',
                'description' => 'JAMB course designed to help students prepare effectively for UTME with tutorials, past questions, and mock tests.',
                'price' => 5000,
            ],
            [
                'name' => 'WAEC (WASSCE)',
                'slug' => 'waec',
                'description' => 'WAEC preparation course that covers all core subjects with tutorials, past questions, and examiner’s tips.',
                'price' => 8000,
            ],
            [
                'name' => 'NECO SSCE',
                'slug' => 'neco',
                'description' => 'NECO prep course providing guided lessons, solved past questions, and practice tests for better performance.',
                'price' => 8000,
            ],
            [
                'name' => 'GCE (WAEC Private)',
                'slug' => 'gce',
                'description' => 'GCE course tailored for private candidates with flexible study options, past questions, and mock examinations.',
                'price' => 8000,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
