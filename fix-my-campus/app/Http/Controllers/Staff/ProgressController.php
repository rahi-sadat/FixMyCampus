<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintStatusLog;
use App\Models\ProgressNote;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function store(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('staff'), 403);
        abort_unless($complaint->current_staff_id === $request->user()->id, 403);
        abort_if(in_array($complaint->status, ['resolved', 'closed', 'rejected'], true), 422);

        $validated = $request->validate([
            'progress_status' => ['required', 'in:checking,working,waiting,completed'],
            'note' => ['required', 'string', 'min:8'],
        ]);

        ProgressNote::create([
            'complaint_id' => $complaint->id,
            'staff_id' => $request->user()->id,
            'progress_status' => $validated['progress_status'],
            'note' => $validated['note'],
        ]);

        $newStatus = $validated['progress_status'] === 'completed' ? 'resolved' : 'in_progress';
        $oldStatus = $complaint->status;

        $complaint->update([
            'status' => $newStatus,
            'resolved_at' => $newStatus === 'resolved' ? now() : $complaint->resolved_at,
        ]);

        $complaint->assignments()
            ->where('assigned_to', $request->user()->id)
            ->latest()
            ->first()
            ?->update(['status' => $newStatus === 'resolved' ? 'completed' : 'accepted']);

        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'changed_by' => $request->user()->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'remarks' => $validated['note'],
            'created_at' => now(),
        ]);

        return back()->with('status', 'Progress update saved.');
    }
}
