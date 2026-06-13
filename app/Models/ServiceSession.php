<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'started_at',
        'ended_at',
        'started_by_user_id',
        'session_date',
        'pastor_id',
        'service_title',
        'verse'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'session_date' => 'datetime',
    ];

    public function startedBy()
    {
        return $this->belongsTo(User::class, 'started_by_user_id');
    }

    public function pastor()
    {
        return $this->belongsTo(User::class, 'pastor_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'service_session_id');
    }
}