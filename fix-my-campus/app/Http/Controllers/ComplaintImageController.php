<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use Illuminate\Http\Request;

class ComplaintImageController extends Controller
{
    public function store(Request $request, Complaint $complaint)
    {
        $this->authorizeImageUpload($request, $complaint);

        $validated = $request->validate([
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        foreach ($validated['images'] as $image) {
            $path = $image->store('complaint-images/'.$complaint->complaint_no, 'public');

            ComplaintImage::create([
                'complaint_id' => $complaint->id,
                'uploaded_by' => $request->user()->id,
                'image_path' => $path,
                'image_name' => $image->getClientOriginalName(),
            ]);
        }

        return back()->with('status', 'Image attachment uploaded successfully.');
    }

    private function authorizeImageUpload(Request $request, Complaint $complaint): void
    {
        $user = $request->user()->loadMissing('role');
        $role = $user->role->role_name ?? null;

        abort_if($role === 'student' && $complaint->student_id !== $user->id, 403);
        abort_if($role === 'staff' && $complaint->current_staff_id !== $user->id, 403);
        abort_unless(in_array($role, ['admin', 'staff', 'student'], true), 403);
    }
}
