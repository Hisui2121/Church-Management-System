<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [

        'first_name',
        'last_name',
        'birthdate',
        'gender',

        'contact_number',
        'email',
        'address',

        'profile_photo',

        'member_status',
        'member_type',

        'date_joined',
    ];
}