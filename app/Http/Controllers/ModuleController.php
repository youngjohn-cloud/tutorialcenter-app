<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Module;

class ModuleController extends Controller
{
    // create module
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|integer|exists:subjects,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['description'] = $data['description'] ?? null;

        // determine next order for the given subject_id
        $maxOrder = Module::where('subject_id', $data['subject_id'])->max('order');
        $data['order'] = ($maxOrder ?? 0) + 1;

        try {
            $module = Module::create($data);

            return response()->json([
                'message' => 'Module created successfully.',
                'data' => $module,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create module.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);
        $query = Module::query();

        if ($request->has('subject_id')) {
            $query->where('subject_id', (int) $request->get('subject_id'));
        }

        $query->orderBy('order');

        if ($request->boolean('all')) {
            $modules = $query->get();
            return response()->json(['data' => $modules], 200);
        }

        $modules = $query->paginate($perPage);
        return response()->json($modules, 200);
    }

    public function show($id)
    {
        $module = Module::find($id);

        if (!$module) {
            return response()->json(['message' => 'Module not found.'], 404);
        }

        return response()->json(['data' => $module], 200);
    }

    public function update(Request $request, $id)
    {
        $module = Module::find($id);

        if (!$module) {
            return response()->json(['message' => 'Module not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'subject_id' => 'sometimes|integer|exists:subjects,id',
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Ensure description is explicitly nullable when provided as missing
        if (array_key_exists('description', $data) && $data['description'] === null) {
            $data['description'] = null;
        }

        // If subject changed, move module to end of new subject ordering
        if (array_key_exists('subject_id', $data) && $data['subject_id'] != $module->subject_id) {
            $maxOrder = Module::where('subject_id', $data['subject_id'])->max('order');
            $data['order'] = ($maxOrder ?? 0) + 1;
        }

        try {
            $module->update($data);

            return response()->json([
                'message' => 'Module updated successfully.',
                'data' => $module->fresh(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update module.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $module = Module::find($id);

        if (!$module) {
            return response()->json(['message' => 'Module not found.'], 404);
        }

        try {
            $module->delete();

            return response()->json([
                'message' => 'Module deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete module.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
