<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'service_id',
        'date',
        'is_present',
        'recorded_by',
    ];

    protected $casts = [
        'date' => 'date',
        'is_present' => 'boolean',
    ];

    public function getStatusAttribute(): string
    {
        return $this->is_present ? 'Present' : 'Absent';
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
