<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        return view('admin.reports.index', [
            'totalComplaints' => Complaint::count(),
            'statusCounts' => Complaint::query()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'priorityCounts' => Complaint::query()->selectRaw('priority, count(*) as total')->groupBy('priority')->pluck('total', 'priority'),
            'categoryCounts' => ComplaintCategory::query()->withCount('complaints')->orderByDesc('complaints_count')->get(),
        ]);
    }
}
