<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_no',
        'student_id',
        'category_id',
        'location_id',
        'current_staff_id',
        'title',
        'description',
        'priority',
        'status',
        'submitted_at',
        'resolved_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function category()
    {
        return $this->belongsTo(ComplaintCategory::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function currentStaff()
    {
        return $this->belongsTo(User::class, 'current_staff_id');
    }

    public function assignments()
    {
        return $this->hasMany(ComplaintAssignment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ComplaintStatusLog::class);
    }

    public function progressNotes()
    {
        return $this->hasMany(ProgressNote::class);
    }

    public function images()
    {
        return $this->hasMany(ComplaintImage::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function scopeVisibleTo($query, User $user)
    {
        $role = $user->role->role_name ?? null;

        if ($role === 'student') {
            return $query->where('student_id', $user->id);
        }

        if ($role === 'staff') {
            return $query->where('current_staff_id', $user->id);
        }

        return $query;
    }

    public function isResolved(): bool
    {
        return in_array($this->status, ['resolved', 'closed'], true);
    }
}
