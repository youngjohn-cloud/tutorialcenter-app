<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterclassSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'masterclass_id',
        'title',
        'description',
        'status',
        'day',
        'start_time',
        'end_time',
        'created_by',
        'updated_by',
    ];

    /**
     * Relationships
     */

    // Each schedule belongs to one masterclass
    public function masterclass()
    {
        return $this->belongsTo(Masterclass::class);
    }

    // Created by a staff
    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    // Updated by a staff
    public function updater()
    {
        return $this->belongsTo(Staff::class, 'updated_by');
    }
}
