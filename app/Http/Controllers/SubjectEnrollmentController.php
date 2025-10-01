<?php

namespace App\Http\Controllers;

use App\Models\SubjectEnrollment;
use Illuminate\Http\Request;

class SubjectEnrollmentController extends Controller
{
     /**
     * Store a new subject enrollment.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'progress' => 'required|numeric|min:0|max:100',
        ]);

        $subjectEnrollment = SubjectEnrollment::findOrFail($id);

        $subjectEnrollment->update([
            'progress' => $validated['progress'],
        ]);

        return response()->json([
            'message' => 'Progress updated successfully',
            'data'    => $subjectEnrollment,
        ]);
    }

}
