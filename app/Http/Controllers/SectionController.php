<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Display a list of all active sections.
     */
    public function index()
    {
        $sections = Section::active()->get();

        return response()->json($sections);
    }

    /**
     * Store a new section.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:sections,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Class creation failed.',
                'errors' => $validator->errors()
            ], 422);
        }
        // Create the section
        try {
            $existingSection = Section::where('name', $request->name)->first();
            if ($existingSection) {
                return response()->json([
                    'message' => "Section with this $request->name already exists.",
                ], 422);
            }

            $section = Section::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'status' => 'active',
                'price' => $request->price ?? 0.00,
            ]);

            return response()->json([
                'message' => 'Section created successfully.',
                'section' => $section
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error checking existing section: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show a single section by ID or slug.
     */
    public function show($identifier)
    {
        $section = Section::where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->firstOrFail();

        return response()->json($section);
    }

    /**
     * Update an existing section.
     */
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:sections,name,' . $section->id,
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
            'price' => 'nullable|numeric|min:0',
        ]);

        $section->update([
            'name' => $request->name ?? $section->name,
            'slug' => Str::slug($request->name ?? $section->name),
            'description' => $request->description ?? $section->description,
            'status' => $request->status ?? $section->status,
            'price' => $request->price ?? $section->price,
        ]);

        return response()->json([
            'message' => 'Section updated successfully.',
            'section' => $section
        ]);
    }

    /**
     * Delete (soft delete) a section.
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return response()->json([
            'message' => 'Section deleted successfully.'
        ]);
    }
}
