<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    protected $fillable = [
        'subject_id',
        'title',
        'description',
        'order',
    ];
}
