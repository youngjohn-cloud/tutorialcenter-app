<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Masterclass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject_id',
        'title',
        'description',
        'assignees_id',
    ];

    protected $casts = [
        'assignees_id' => 'array', // stores staff IDs as JSON
    ];

    /**
     * Relationships
     */

    // A masterclass belongs to a subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // A masterclass has many schedules
    public function schedules()
    {
        return $this->hasMany(MasterclassSchedule::class);
    }

    // Tutors or staff assigned to this masterclass (JSON array of IDs)
    public function assignees()
    {
        return $this->belongsToMany(Staff::class, 'staffs', 'id', 'assignees_id');
    }
}
