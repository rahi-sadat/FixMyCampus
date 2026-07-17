<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\BuildsComplaintFixtures;
use Tests\TestCase;

class ComplaintReviewViewTest extends TestCase
{
    use BuildsComplaintFixtures, RefreshDatabase;

    public function test_admin_can_open_review_detail(): void
    {
        $admin = $this->userWithRole('admin');
        $complaint = $this->complaintFor($this->userWithRole('student'));

        $this->actingAs($admin)->get(route('admin.complaints.show', $complaint))
            ->assertOk()
            ->assertSee($complaint->complaint_no)
            ->assertSee('Assign staff');
    }
}
