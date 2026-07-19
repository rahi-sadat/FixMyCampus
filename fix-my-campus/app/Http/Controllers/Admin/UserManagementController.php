<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintAssignment;
use App\Models\ComplaintImage;
use App\Models\ComplaintStatusLog;
use App\Models\Feedback;
use App\Models\ProgressNote;
use App\Models\User;
use App\Services\ComplaintDeletionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    public function destroy(Request $request, User $user, ComplaintDeletionService $complaintDeletion)
    {
        abort_unless($request->user()->isRole('admin'), 403);
        abort_if($request->user()->is($user), 422, 'You cannot delete your own authority account.');

        $role = $user->load('role')->role->role_name ?? null;
        abort_unless(in_array($role, ['student', 'staff'], true), 422);

        DB::transaction(function () use ($user, $role, $complaintDeletion): void {
            if ($role === 'student') {
                Complaint::query()
                    ->where('student_id', $user->id)
                    ->with('images')
                    ->get()
                    ->each(fn (Complaint $complaint) => $complaintDeletion->delete($complaint));
            }

            $this->deleteUploadedImages($user);

            if ($role === 'staff') {
                Complaint::query()
                    ->where('current_staff_id', $user->id)
                    ->whereNotIn('status', ['resolved', 'closed', 'rejected'])
                    ->update([
                        'current_staff_id' => null,
                        'status' => 'pending',
                    ]);

                Complaint::query()
                    ->where('current_staff_id', $user->id)
                    ->update(['current_staff_id' => null]);
            }

            Feedback::query()->where('student_id', $user->id)->delete();
            ProgressNote::query()->where('staff_id', $user->id)->delete();
            ComplaintAssignment::query()
                ->where('assigned_by', $user->id)
                ->orWhere('assigned_to', $user->id)
                ->delete();
            ComplaintStatusLog::query()->where('changed_by', $user->id)->delete();

            $user->delete();
        });

        return back()->with('status', ucfirst($role).' account deleted successfully.');
    }

    private function deleteUploadedImages(User $user): void
    {
        ComplaintImage::query()
            ->where('uploaded_by', $user->id)
            ->get()
            ->each(function (ComplaintImage $image): void {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            });
    }
}
