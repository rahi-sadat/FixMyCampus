<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'student_id',
        'staff_id',
        'department',
        'designation',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function submittedComplaints()
    {
        return $this->hasMany(Complaint::class, 'student_id');
    }

    public function assignedComplaints()
    {
        return $this->hasMany(Complaint::class, 'current_staff_id');
    }

    public function assignmentsMade()
    {
        return $this->hasMany(ComplaintAssignment::class, 'assigned_by');
    }

    public function progressNotes()
    {
        return $this->hasMany(ProgressNote::class, 'staff_id');
    }

    public function uploadedComplaintImages()
    {
        return $this->hasMany(ComplaintImage::class, 'uploaded_by');
    }

    public function isRole(string $role): bool
    {
        return ($this->role->role_name ?? null) === $role;
    }
}
