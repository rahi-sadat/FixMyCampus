<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'description',
        'status',
    ];

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'category_id');
    }
}
