<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;

class ComplaintReviewController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:pending,assigned,in_progress,resolved,rejected,closed'],
            'priority' => ['nullable', 'in:low,medium,high,urgent'],
            'category_id' => ['nullable', 'integer', 'exists:complaint_categories,id'],
        ]);

        $complaints = Complaint::query()
            ->with(['student', 'category', 'location', 'currentStaff'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('complaint_no', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['priority'] ?? null, fn ($query, $priority) => $query->where('priority', $priority))
            ->when($filters['category_id'] ?? null, fn ($query, $category) => $query->where('category_id', $category))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.complaints.index', [
            'complaints' => $complaints,
            'categories' => ComplaintCategory::query()->orderBy('category_name')->get(),
        ]);
    }

    public function show(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        $complaint->load([
            'student', 'category', 'location', 'currentStaff',
            'assignments.assigner', 'assignments.staff', 'images.uploader',
            'statusLogs.user', 'progressNotes.staff', 'feedback.student',
        ]);

        return view('admin.complaints.show', compact('complaint'));
    }
}
