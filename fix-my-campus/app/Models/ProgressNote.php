<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'staff_id',
        'note',
        'progress_status',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
