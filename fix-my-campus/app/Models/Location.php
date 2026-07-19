<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'building_name',
        'floor_no',
        'room_no',
        'description',
    ];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function label(): string
    {
        return collect([$this->location_name, $this->building_name, $this->floor_no, $this->room_no])
            ->filter()
            ->join(', ');
    }
}
