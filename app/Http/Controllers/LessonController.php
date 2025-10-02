<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display a listing of lessons (optionally by module).
     */
    public function index(Request $request)
    {
        $query = Lesson::query();

        // Filter by module if provided
        if ($request->has('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        $lessons = $query->orderBy('order')->get();

        return response()->json($lessons);
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'material_url' => 'nullable|file|mimes:pdf,docs,docx',
            'video_thumbnail' => 'nullable|image|mimes:jpg,png,jpeg',
            'video_url' => 'required|video|mimes:ffmpeg,mp4,wav',
        ]);

        $validated['uploaded_by'] = Auth::id(); // staff who uploaded
        $validated['updated_by'] = Auth::id();
        // determine next order for the given subject_id
        $maxOrder = Lesson::where('module_id', $validated['module_id'])->max('order');
        $validated['order'] = ($maxOrder ?? 0) + 1;
        try {

            $lesson = Lesson::create($validated);

            return response()->json([
                'message' => 'Lesson created successfully.',
                'lesson' => $lesson
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create module.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified lesson.
     */
    public function show(Lesson $lesson)
    {
        return response()->json($lesson);
    }

    /**
     * Update the specified lesson.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'material_url' => 'nullable|string',
            'video_thumbnail' => 'nullable|string',
            'video_url' => 'sometimes|required|string',
            'order' => 'sometimes|required|integer',
        ]);

        $validated['updated_by'] = Auth::id();

        $lesson->update($validated);

        return response()->json([
            'message' => 'Lesson updated successfully.',
            'lesson' => $lesson
        ]);
    }

    /**
     * Remove the specified lesson (soft delete).
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json([
            'message' => 'Lesson deleted successfully.'
        ]);
    }
}
