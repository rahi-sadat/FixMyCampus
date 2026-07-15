<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintTrackingController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->isRole('student'), 403);

        $complaints = Complaint::query()
            ->with(['category', 'location', 'currentStaff'])
            ->where('student_id', $request->user()->id)
            ->latest()
            ->paginate(12);

        return view('student.complaints.index', compact('complaints'));
    }

    public function show(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('student'), 403);
        abort_unless($complaint->student_id === $request->user()->id, 403);

        $complaint->load([
            'category', 'location', 'currentStaff', 'images.uploader',
            'statusLogs.user', 'progressNotes.staff', 'feedback',
        ]);

        return view('student.complaints.show', compact('complaint'));
    }
}
