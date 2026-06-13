<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'user_id',
        'service_session_id',
        'service_id',
        'date',
        'checked_in_at',
        'is_present',
        'recorded_by',
    ];

    protected $casts = [
        'date' => 'date',
        'checked_in_at' => 'datetime',
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

    public function serviceSession()
    {
        return $this->belongsTo(ServiceSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
