<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\BuildsComplaintFixtures;
use Tests\TestCase;

class ComplaintReportViewTest extends TestCase
{
    use BuildsComplaintFixtures, RefreshDatabase;

    public function test_report_page_displays_existing_summaries(): void
    {
        $admin = $this->userWithRole('admin');
        $this->complaintFor($this->userWithRole('student'));

        $this->actingAs($admin)->get(route('admin.reports.index'))
            ->assertOk()
            ->assertSee('Complaint overview')
            ->assertSee('By priority')
            ->assertSee('By category');
    }
}
