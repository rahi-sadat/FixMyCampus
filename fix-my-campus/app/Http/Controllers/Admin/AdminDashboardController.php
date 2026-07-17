<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        $statusCounts = Complaint::query()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $priorityCounts = Complaint::query()->selectRaw('priority, count(*) as total')->groupBy('priority')->pluck('total', 'priority');
        $categoryCounts = ComplaintCategory::query()->withCount('complaints')->orderByDesc('complaints_count')->get();
        $complaints = Complaint::query()->with(['student', 'category', 'location', 'currentStaff'])->latest()->take(8)->get();
        $staff = User::query()
            ->whereHas('role', fn ($query) => $query->where('role_name', 'staff'))
            ->withCount(['assignedComplaints as open_assignments_count' => fn ($query) => $query->whereNotIn('status', ['resolved', 'closed'])])
            ->orderBy('name')->get();
        $students = User::query()
            ->whereHas('role', fn ($query) => $query->where('role_name', 'student'))
            ->withCount('submittedComplaints')->orderBy('name')->get();

        return view('dashboards.admin', [
            'complaints' => $complaints,
            'statusCounts' => $statusCounts,
            'priorityCounts' => $priorityCounts,
            'categoryCounts' => $categoryCounts,
            'staff' => $staff,
            'students' => $students,
            'totalComplaints' => Complaint::count(),
            'totalStudents' => $students->count(),
            'totalStaff' => $staff->count(),
        ]);
    }
}
