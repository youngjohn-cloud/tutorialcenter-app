<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'end_date'   =>   'required|in:monthly,quarterly,half_year,annually',
            'subjects'   => 'required|array',
            'subjects.*.id' => 'required|exists:subjects,id',
            'subjects.*.progress'   => 'nullable|numeric|min:0|max:100',
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $request->student_id,
            'course_id'  => $request->course_id,
            'end_date'   => $this->calculateEndDate($request->end_date)
        ]);

        return response()->json([
            'message' => 'Enrollment created successfully',
            'data'    => $enrollment->load('subjectEnrollments')
        ], 201);
    }


    private function calculateEndDate($duration){
        return match ($duration) {
            'monthly'   => Carbon::now()->addMonth(),
            'quarterly' => Carbon::now()->addMonths(3),
            'half_year' => Carbon::now()->addMonths(6),
            'annually'  => Carbon::now()->addYear(),
            default     => Carbon::now(),
        };
    }
}
