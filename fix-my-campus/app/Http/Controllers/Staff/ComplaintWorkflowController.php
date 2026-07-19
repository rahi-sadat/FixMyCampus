<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintWorkflowController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->isRole('staff'), 403);

        $complaints = Complaint::query()
            ->with(['student', 'category', 'location'])
            ->where('current_staff_id', $request->user()->id)
            ->latest()->paginate(15);

        return view('staff.complaints.index', compact('complaints'));
    }

    public function show(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('staff'), 403);
        abort_unless($complaint->current_staff_id === $request->user()->id, 403);

        $complaint->load([
            'student', 'category', 'location', 'images.uploader',
            'statusLogs.user', 'progressNotes.staff',
        ]);

        return view('staff.complaints.show', compact('complaint'));
    }
}
