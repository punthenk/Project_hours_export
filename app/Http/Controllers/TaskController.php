<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
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
        $validate = $request->validate(
            [
                'name' => 'required|string|max:40',
                'description' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Please give the project a name',
            ]
        );

        Task::create([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'project_id' => $request->project_id,
        ]);

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
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'required|string|max:255',
            'worked_time' => 'nullable|numeric|min:0',
        ]);

        $task->update($validated);

        return redirect()->back();
    }

    public function toggleChecked(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return response()->json(['completed' => $task->completed]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back();
    }
}
