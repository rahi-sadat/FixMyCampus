<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\BuildsComplaintFixtures;
use Tests\TestCase;

class ComplaintReportTest extends TestCase
{
    use BuildsComplaintFixtures, RefreshDatabase;

    public function test_only_admin_can_open_reports(): void
    {
        $this->actingAs($this->userWithRole('admin'))
            ->get(route('admin.reports.index'))
            ->assertOk();

        $this->actingAs($this->userWithRole('student'))
            ->get(route('admin.reports.index'))
            ->assertForbidden();
    }
}
