<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\ComplaintImage;
use App\Models\ComplaintStatusLog;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintSubmissionController extends Controller
{
    public function create(Request $request)
    {
        abort_unless($request->user()->isRole('student'), 403);

        return view('student.complaints.create', [
            'categories' => ComplaintCategory::query()->where('status', 'active')->orderBy('category_name')->get(),
            'locations' => Location::query()->orderBy('building_name')->orderBy('location_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->isRole('student'), 403);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:complaint_categories,id'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'location_name' => ['required_without:location_id', 'nullable', 'string', 'max:150'],
            'building_name' => ['nullable', 'string', 'max:100'],
            'floor_no' => ['nullable', 'string', 'max:20'],
            'room_no' => ['nullable', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'min:15'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $locationId = $validated['location_id'] ?? null;

        if (! $locationId) {
            $locationId = Location::firstOrCreate([
                'location_name' => $validated['location_name'],
                'building_name' => $validated['building_name'] ?? null,
                'floor_no' => $validated['floor_no'] ?? null,
                'room_no' => $validated['room_no'] ?? null,
            ])->id;
        }

        $complaint = Complaint::create([
            'complaint_no' => 'FMC-'.now()->format('ymd').'-'.strtoupper(Str::random(5)),
            'student_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'location_id' => $locationId,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'changed_by' => $request->user()->id,
            'new_status' => 'pending',
            'remarks' => 'Complaint submitted.',
            'created_at' => now(),
        ]);

        foreach ($request->file('images', []) as $image) {
            ComplaintImage::create([
                'complaint_id' => $complaint->id,
                'uploaded_by' => $request->user()->id,
                'image_path' => $image->store('complaint-images/'.$complaint->complaint_no, 'public'),
                'image_name' => $image->getClientOriginalName(),
            ]);
        }

        return redirect()->route('complaints.show', $complaint)
            ->with('status', 'Complaint submitted successfully.');
    }
}
