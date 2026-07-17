<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintAssignment;
use App\Models\ComplaintStatusLog;
use App\Models\User;
use Illuminate\Http\Request;

class ComplaintAssignmentController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        return view('admin.assignments.index', [
            'complaints' => Complaint::query()
                ->with(['category', 'location', 'currentStaff'])
                ->whereNotIn('status', ['resolved', 'closed', 'rejected'])
                ->latest()->paginate(15),
        ]);
    }

    public function edit(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('admin'), 403);
        abort_if(in_array($complaint->status, ['resolved', 'closed', 'rejected'], true), 422);

        return view('admin.assignments.edit', [
            'complaint' => $complaint->load(['category', 'location', 'currentStaff']),
            'staff' => User::query()
                ->where('status', 'active')
                ->whereHas('role', fn ($query) => $query->where('role_name', 'staff'))
                ->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('admin'), 403);
        abort_if(in_array($complaint->status, ['resolved', 'closed', 'rejected'], true), 422);

        $validated = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
            'assignment_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $staff = User::findOrFail($validated['assigned_to']);
        abort_unless($staff->isRole('staff') && $staff->status === 'active', 422);

        $complaint->assignments()->whereIn('status', ['assigned', 'accepted'])->update(['status' => 'cancelled']);

        ComplaintAssignment::create([
            'complaint_id' => $complaint->id,
            'assigned_by' => $request->user()->id,
            'assigned_to' => $staff->id,
            'assignment_note' => $validated['assignment_note'] ?? null,
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $oldStatus = $complaint->status;
        $complaint->update(['current_staff_id' => $staff->id, 'status' => 'assigned']);

        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'changed_by' => $request->user()->id,
            'old_status' => $oldStatus,
            'new_status' => 'assigned',
            'remarks' => 'Assigned to '.$staff->name.'.',
            'created_at' => now(),
        ]);

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('status', 'Complaint assigned successfully.');
    }
}
