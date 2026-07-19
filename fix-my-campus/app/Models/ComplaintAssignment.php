<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'assigned_by',
        'assigned_to',
        'assignment_note',
        'status',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
