<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\WorkedSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkedSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'started_at' => 'required|date_format:H:i',
                'stopped_at' => 'required|date_format:H:i|after:started_at',
                'task_id' => 'required|exists:tasks,id',
            ],
            [
                'started_at.required' => "Please fill in the started time",
                'stopped_at.required' => "Please fill in the stopped time",
                'stopped_at.exists' => "Your strart time must be before you stopped",
                'task_id.required' => "You must select a task or create one first",
                'task_id.exists' => "Selected task does not exist",
            ]
        );


        $start = \Carbon\Carbon::createFromFormat('H:i', $validated['started_at']);
        $end = \Carbon\Carbon::createFromFormat('H:i', $validated['stopped_at']);
        $duration = $start->diffInMinutes($end);

        WorkedSession::create([
            'task_id' => $validated['task_id'],
            'started_at' => $start->format('H:i:s'),
            'stopped_at' => $end->format('H:i:s'),
            'duration' => $duration,
        ]);

        $task = Task::find($validated['task_id']);
        $task->updateWorkedTime();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkedSession $session)
    {
        $start = \Carbon\Carbon::createFromFormat('H:i', $request['started_at']);
        $end = \Carbon\Carbon::createFromFormat('H:i', $request['stopped_at']);
        $duration = $start->diffInMinutes($end);

        Log::debug($start);
        Log::debug($end);
        Log::debug($duration);

        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'started_at' => 'required|date_format:H:i',
            'stopped_at' => 'required|date_format:H:i|after:started_at',
            'created_at' => 'required|date',
        ]);
        $validated['duration'] = $duration;

        // First update the sessions because else the updateWorkedTime dont work with the new values
        $session->update($validated);

        $task = Task::find($validated['task_id']);
        $task->updateWorkedTime();


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $session = Task::findOrFail($id);
        $session->delete();

        return redirect()->back();
    }
}
