<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_unless($request->user()->isRole('student'), 403);

        $complaints = Complaint::query()
            ->with(['category', 'location', 'currentStaff', 'feedback'])
            ->where('student_id', $request->user()->id)
            ->latest()
            ->get();

        return view('dashboards.student', [
            'complaints' => $complaints,
            'openCount' => $complaints->whereNotIn('status', ['resolved', 'closed', 'rejected'])->count(),
            'resolvedCount' => $complaints->whereIn('status', ['resolved', 'closed'])->count(),
        ]);
    }
}
