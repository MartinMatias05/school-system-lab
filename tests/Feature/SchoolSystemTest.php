<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_redirects_to_student_roster(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('students.index'));
    }

    public function test_student_roster_page_loads(): void
    {
        $response = $this->get(route('students.index'));

        $response->assertOk();
        $response->assertSee('Student Roster');
    }

    public function test_registered_students_are_shown_on_roster(): void
    {
        Student::create([
            'student_number' => 'LAB-0001',
            'first_name' => 'Alex',
            'last_name' => 'Santos',
            'email' => 'alex@example.com',
            'date_of_birth' => '2005-01-15',
        ]);

        $this->get(route('students.index'))
            ->assertOk()
            ->assertSee('LAB-0001')
            ->assertSee('Alex Santos');
    }

    public function test_course_can_be_created_through_the_form(): void
    {
        $this->post(route('courses.store'), [
            'code' => 'TEST101', 'title' => 'Testing Fundamentals', 'credits' => 3,
        ])->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', ['code' => 'TEST101', 'title' => 'Testing Fundamentals']);
    }
}
