<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintAssignment;
use App\Models\ComplaintStatusLog;
use App\Models\User;
use App\Services\ComplaintDeletionService;
use Illuminate\Http\Request;

class ComplaintManagementController extends Controller
{
    public function assign(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        $validated = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
            'assignment_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $staff = User::findOrFail($validated['assigned_to']);
        abort_unless($staff->isRole('staff'), 422);

        ComplaintAssignment::create([
            'complaint_id' => $complaint->id,
            'assigned_by' => $request->user()->id,
            'assigned_to' => $staff->id,
            'assignment_note' => $validated['assignment_note'] ?? null,
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $oldStatus = $complaint->status;
        $complaint->update([
            'current_staff_id' => $staff->id,
            'status' => 'assigned',
        ]);

        $this->logStatus($complaint, $request->user()->id, $oldStatus, 'assigned', 'Assigned to '.$staff->name.'.');

        return back()->with('status', 'Complaint assigned successfully.');
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,assigned,in_progress,resolved,rejected,closed'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $oldStatus = $complaint->status;

        $complaint->update([
            'status' => $validated['status'],
            'resolved_at' => in_array($validated['status'], ['resolved', 'closed'], true) ? now() : $complaint->resolved_at,
        ]);

        $this->logStatus($complaint, $request->user()->id, $oldStatus, $validated['status'], $validated['remarks'] ?? 'Status updated by authority.');

        return back()->with('status', 'Complaint status updated.');
    }

    public function destroy(Request $request, Complaint $complaint, ComplaintDeletionService $complaintDeletion)
    {
        abort_unless($request->user()->isRole('admin'), 403);

        $complaintNo = $complaint->complaint_no;
        $complaintDeletion->delete($complaint);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', "Complaint {$complaintNo} deleted successfully.");
    }

    private function logStatus(Complaint $complaint, int $userId, ?string $oldStatus, string $newStatus, ?string $remarks): void
    {
        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'changed_by' => $userId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'remarks' => $remarks,
            'created_at' => now(),
        ]);
    }
}
