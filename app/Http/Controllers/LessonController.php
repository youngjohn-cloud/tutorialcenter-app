<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'material_url' => 'nullable|file|mimes:pdf,doc,docx',
            'video_thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video_url' => 'required|file|mimes:mp4,mov,avi,mkv,wmv|max:51200',
        ]);

        $validated['uploaded_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // 🔹 Determine next order within the same module
        $maxOrder = Lesson::where('module_id', $validated['module_id'])->max('order');
        $validated['order'] = ($maxOrder ?? 0) + 1;

        try {
            // 🔹 Handle file uploads
            if ($request->hasFile('material_url')) {
                $validated['material_url'] = $request->file('material_url')->store('lessons/materials', 'public');
            }

            if ($request->hasFile('video_thumbnail')) {
                $validated['video_thumbnail'] = $request->file('video_thumbnail')->store('lessons/thumbnails', 'public');
            }

            if ($request->hasFile('video_url')) {
                $validated['video_url'] = $request->file('video_url')->store('lessons/videos', 'public');
            }

            // 🔹 Create lesson
            $lesson = Lesson::create($validated);

            return response()->json([
                'message' => 'Lesson created successfully.',
                'lesson' => $lesson
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create lesson.',
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
            'material_url' => 'nullable|file|mimes:pdf,doc,docx',
            'video_thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video_url' => 'sometimes|required|file|mimes:mp4,mov,avi,mkv,wmv|max:51200',
            'order' => 'sometimes|required|integer',
        ]);

        $validated['updated_by'] = Auth::id();

        try {
            // 🔹 Handle material replacement
            if ($request->hasFile('material_url')) {
                // Delete old material if exists
                if ($lesson->material_url && Storage::disk('public')->exists($lesson->material_url)) {
                    Storage::disk('public')->delete($lesson->material_url);
                }
                $validated['material_url'] = $request->file('material_url')->store('lessons/materials', 'public');
            }

            // 🔹 Handle video thumbnail replacement
            if ($request->hasFile('video_thumbnail')) {
                if ($lesson->video_thumbnail && Storage::disk('public')->exists($lesson->video_thumbnail)) {
                    Storage::disk('public')->delete($lesson->video_thumbnail);
                }
                $validated['video_thumbnail'] = $request->file('video_thumbnail')->store('lessons/thumbnails', 'public');
            }

            // 🔹 Handle video replacement
            if ($request->hasFile('video_url')) {
                if ($lesson->video_url && Storage::disk('public')->exists($lesson->video_url)) {
                    Storage::disk('public')->delete($lesson->video_url);
                }
                $validated['video_url'] = $request->file('video_url')->store('lessons/videos', 'public');
            }

            // 🔹 Update lesson
            $lesson->update($validated);

            return response()->json([
                'message' => 'Lesson updated successfully.',
                'lesson' => $lesson
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update lesson.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
