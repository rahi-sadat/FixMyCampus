<?php

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;

class ComplaintDeletionService
{
    public function delete(Complaint $complaint): void
    {
        $complaint->loadMissing('images');

        foreach ($complaint->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $complaint->delete();
    }
}
