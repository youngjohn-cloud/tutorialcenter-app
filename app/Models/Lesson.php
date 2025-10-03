<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'material_url',
        'video_thumbnail',
        'video_url',
        'uploaded_by',
        'updated_by',
        'order',
    ];

    /**
     * Each lesson belongs to a module.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Staff who uploaded the lesson.
     */
    public function uploader()
    {
        return $this->belongsTo(Staff::class, 'uploaded_by');
    }

    /**
     * Staff who last updated the lesson.
     */
    public function updater()
    {
        return $this->belongsTo(Staff::class, 'updated_by');
    }
}
