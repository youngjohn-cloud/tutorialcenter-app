<?php

namespace App\Observers;

use App\Models\Enrollment;
use App\Models\SubjectEnrollment;

class EnrollmentObserver
{
    /**
     * Handle the Enrollment "created" event.
     */
    public function created(Enrollment $enrollment): void
    {
        // Get subjects from request JSON
        $subjects = request()->input('subjects', []);

        foreach ($subjects as $subj) {
            SubjectEnrollment::create([
                'student_id'    => $enrollment->student_id,
                'subject_id'    => $subj['id'],
                'enrollment_id' => $enrollment->id,
                'progress'      => $subj['progress'] ?? 0,
            ]);
        }
    }

    /**
     * Handle the Enrollment "updated" event.
     */
    public function updated(Enrollment $enrollment): void
    {
        //
    }

    /**
     * Handle the Enrollment "deleted" event.
     */
    public function deleted(Enrollment $enrollment): void
    {
        //
    }

    /**
     * Handle the Enrollment "restored" event.
     */
    public function restored(Enrollment $enrollment): void
    {
        //
    }

    /**
     * Handle the Enrollment "force deleted" event.
     */
    public function forceDeleted(Enrollment $enrollment): void
    {
        //
    }
}
