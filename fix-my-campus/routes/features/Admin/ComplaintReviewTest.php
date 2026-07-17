<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\BuildsComplaintFixtures;
use Tests\TestCase;

class ComplaintReviewTest extends TestCase
{
    use BuildsComplaintFixtures, RefreshDatabase;

    public function test_admin_can_search_complaints(): void
    {
        $admin = $this->userWithRole('admin');
        $student = $this->userWithRole('student');
        $this->complaintFor($student, title: 'Unique projector fault');
        $this->complaintFor($student, title: 'Unrelated water issue');

        $this->actingAs($admin)->get(route('admin.complaints.index', ['search' => 'projector']))
            ->assertOk()
            ->assertSee('Unique projector fault')
            ->assertDontSee('Unrelated water issue');
    }
}
