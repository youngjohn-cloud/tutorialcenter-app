<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a list of all courses.
     */
    public function index()
    {
        $courses = Course::latest()->get();
        return response()->json($courses, 200);
    }

    /**
     * Store a new course.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sections_ids' => 'nullable|array',
            'tutors_assignees' => 'nullable|array',
            'created_by' => 'required|exists:staff,staff_id',
            'status' => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $course = Course::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'sections_ids' => $request->sections_ids ?? [],
            'tutors_assignees' => $request->tutors_assignees ?? [],
            'created_by' => $request->created_by,
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'message' => 'Course created successfully.',
            'course'  => $course
        ], 201);
    }

    /**
     * Show a specific course.
     */
    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        return response()->json($course, 200);
    }

    /**
     * Update a course.
     */
    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'              => 'sometimes|string|max:255',
            'description'       => 'sometimes|string',
            'sections_ids'      => 'nullable|array',
            'tutors_assignees'  => 'nullable|array',
            'status'            => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $course->update($request->only([
            'name',
            'description',
            'sections_ids',
            'tutors_assignees',
            'status',
        ]));

        if ($request->has('name')) {
            $course->slug = Str::slug($request->name) . '-' . uniqid();
            $course->save();
        }

        return response()->json(['message' => 'Course updated.', 'course' => $course], 200);
    }

    /**
     * Soft delete a course.
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        $course->delete();

        return response()->json(['message' => 'Course deleted.'], 200);
    }
}
