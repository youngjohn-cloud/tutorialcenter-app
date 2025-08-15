<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sections_ids',
        'departments',
        'created_by',
        'status',
        'tutors_assignees',
    ];

    protected $casts = [
        'sections_ids' => 'array',
        'tutors_assignees' => 'array',
        'departments' => 'array',
    ];

    /**
     * Relationship: Course belongs to a staff (creator)
     */
    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }
}
