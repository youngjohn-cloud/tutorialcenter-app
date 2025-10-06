<?php

namespace App\Http\Controllers;

use App\Models\MasterclassSchedule;
use Illuminate\Http\Request;

class MasterclassScheduleController extends Controller
{
    /**
     * List all schedules
     */
    public function index()
    {
        $schedules = MasterclassSchedule::with('masterclass')->get();
        return response()->json($schedules);
    }

    /**
     * Create a new schedule for a masterclass
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'masterclass_id' => 'required|exists:masterclasses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
            'day' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule = MasterclassSchedule::create([
            'masterclass_id' => $validated['masterclass_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'day' => $validated['day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Schedule created successfully',
            'data' => $schedule,
        ], 201);
    }

    /**
     * Show a single schedule
     */
    public function show($id)
    {
        $schedule = MasterclassSchedule::with('masterclass')->findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update a schedule
     */
    public function update(Request $request, $id)
    {
        $schedule = MasterclassSchedule::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
            'day' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        $schedule->update(array_merge($validated, [
            'updated_by' => auth()->id(),
        ]));

        return response()->json([
            'message' => 'Schedule updated successfully',
            'data' => $schedule,
        ]);
    }

    /**
     * Delete a schedule
     */
    public function destroy($id)
    {
        $schedule = MasterclassSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
