<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\ComplaintImage;
use App\Models\ComplaintStatusLog;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $complaints = Complaint::query()
            ->with(['student', 'category', 'location', 'currentStaff'])
            ->visibleTo($request->user()->load('role'))
            ->latest()
            ->paginate(12);

        return view('complaints.index', compact('complaints'));
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->isRole('student'), 403);

        return view('complaints.create', [
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
            $location = Location::firstOrCreate([
                'location_name' => $validated['location_name'],
                'building_name' => $validated['building_name'] ?? null,
                'floor_no' => $validated['floor_no'] ?? null,
                'room_no' => $validated['room_no'] ?? null,
            ]);

            $locationId = $location->id;
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
            'old_status' => null,
            'new_status' => 'pending',
            'remarks' => 'Complaint submitted.',
            'created_at' => now(),
        ]);

        $this->storeImages($request, $complaint);

        return redirect()
            ->route('complaints.show', $complaint)
            ->with('status', 'Complaint submitted successfully.');
    }

    public function show(Request $request, Complaint $complaint)
    {
        $user = $request->user()->load('role');
        $role = $user->role->role_name ?? null;

        abort_if($role === 'student' && $complaint->student_id !== $user->id, 403);
        abort_if($role === 'staff' && $complaint->current_staff_id !== $user->id, 403);

        $complaint->load([
            'student',
            'category',
            'location',
            'currentStaff',
            'assignments.assigner',
            'assignments.staff',
            'images.uploader',
            'statusLogs.user',
            'progressNotes.staff',
            'feedback',
        ]);

        return view('complaints.show', [
            'complaint' => $complaint,
            'staff' => $role === 'admin'
                ? User::query()->whereHas('role', fn ($query) => $query->where('role_name', 'staff'))->orderBy('name')->get()
                : collect(),
        ]);
    }

    private function storeImages(Request $request, Complaint $complaint): void
    {
        foreach ($request->file('images', []) as $image) {
            $path = $image->store('complaint-images/'.$complaint->complaint_no, 'public');

            ComplaintImage::create([
                'complaint_id' => $complaint->id,
                'uploaded_by' => $request->user()->id,
                'image_path' => $path,
                'image_name' => $image->getClientOriginalName(),
            ]);
        }
    }
}
