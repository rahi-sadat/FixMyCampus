<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\BuildsComplaintFixtures;
use Tests\TestCase;

class ComplaintAssignmentViewTest extends TestCase
{
    use BuildsComplaintFixtures, RefreshDatabase;

    public function test_assignment_page_lists_active_staff(): void
    {
        $admin = $this->userWithRole('admin');
        $staff = $this->userWithRole('staff');
        $complaint = $this->complaintFor($this->userWithRole('student'));

        $this->actingAs($admin)->get(route('admin.assignments.edit', $complaint))
            ->assertOk()
            ->assertSee($staff->name);
    }
}
