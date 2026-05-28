<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class auditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'table_name',
        'record_id',
        'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, string $tableName, ?int $recordId = null, ?string $description = null): void {
        static::create([
            'user_id'       => Auth::id(),
            'action'        => $action,
            'table_name'    => $tableName,
            'record_id'     => $recordId,
            'description'   =>$description,
        ]);
    }

}
