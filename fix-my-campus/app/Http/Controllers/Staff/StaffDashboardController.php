<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_unless($request->user()->isRole('staff'), 403);

        $complaints = Complaint::query()
            ->with(['student', 'category', 'location', 'images.uploader'])
            ->where('current_staff_id', $request->user()->id)
            ->latest()->get();

        return view('dashboards.staff', [
            'complaints' => $complaints,
            'openCount' => $complaints->whereNotIn('status', ['resolved', 'closed'])->count(),
            'resolvedCount' => $complaints->whereIn('status', ['resolved', 'closed'])->count(),
        ]);
    }
}
