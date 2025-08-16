<?php
/* Section is use to replace class. 
 * we can't have Class as a name of Object 
 * due to php inbuilt keyword
 * so we decided to use section
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'price',
    ];

    /**
     * Relationships (if needed)
     */

    // public function enrollments()
    // {
    //     return $this->hasMany(Enrollment::class);
    // }

    // public function subjects()
    // {
    //     return $this->hasMany(SectionSubject::class); // if you later create section_subjects
    // }

    /**
     * Optional: scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
