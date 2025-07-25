<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'gender',
        'staff_role',
        'profile_picture',
        'date_of_birth',
        'email_verified_at',
        'phone_verified_at',
        'verification_code',
        'location',
        'home_address',
        'department',
        'inducted_by'
    ];

    

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'date_of_birth' => 'date'
    ];

    /**
     * Automatically hash password before saving
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
