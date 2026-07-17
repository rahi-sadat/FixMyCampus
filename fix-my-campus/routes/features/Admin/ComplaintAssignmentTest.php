<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\BuildsComplaintFixtures;
use Tests\TestCase;

class ComplaintAssignmentTest extends TestCase
{
    use BuildsComplaintFixtures, RefreshDatabase;

    public function test_admin_can_assign_complaint_to_staff(): void
    {
        $admin = $this->userWithRole('admin');
        $staff = $this->userWithRole('staff');
        $complaint = $this->complaintFor($this->userWithRole('student'));

        $this->actingAs($admin)->post(route('admin.assignments.store', $complaint), [
            'assigned_to' => $staff->id,
            'assignment_note' => 'Inspect the issue today.',
        ])->assertRedirect(route('admin.complaints.show', $complaint));

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'current_staff_id' => $staff->id,
            'status' => 'assigned',
        ]);
    }
}
