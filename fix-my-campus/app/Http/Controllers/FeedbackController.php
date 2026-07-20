<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->isRole('student'), 403);
        abort_unless($complaint->student_id === $request->user()->id && $complaint->isResolved(), 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Feedback::updateOrCreate(
            ['complaint_id' => $complaint->id, 'student_id' => $request->user()->id],
            $validated
        );

        return back()->with('status', 'Feedback submitted. Thank you.');
    }
}
