<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'complaint_id',
        'student_id',
        'rating',
        'comment',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
