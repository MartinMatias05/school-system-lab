<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed a few courses so enrollment and activity creation can be tested immediately.
        $courses = [
            ['code' => 'IT101', 'title' => 'Introduction to Information Technology', 'credits' => 3],
            ['code' => 'CS102', 'title' => 'Programming Fundamentals', 'credits' => 3],
            ['code' => 'WEB201', 'title' => 'Web Application Development', 'credits' => 3],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['code' => $course['code']], $course);
        }
    }
}
