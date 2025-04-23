<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'guardian_id'; // Custom primary key

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'gender',
        'profile_picture',
        'date_of_birth',
        'email_verified_at',
        'phone_verified_at',
        'location',
        'home_address',
        'status',
        'students_ids',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'students_ids' => 'array',
    ];

    protected $hidden = [
        'password',
    ];
}
