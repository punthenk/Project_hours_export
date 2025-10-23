<?php

namespace App\Http\Controllers;

use App\Exports\ProjectExport;
use Maatwebsite\Excel\Excel;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = auth()->user()->projects()->get();

        return view("dashboard", ["projects" => $projects]);
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
        $validate = $request->validate([
            'name' => 'required|string|max:40',
        ], [
            'message.required' => 'Please give the project a name',
        ]);

        auth()->user()->projects()->create($validate);

        return redirect('/')->with('success', 'Your chirp has been posted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('tasks')->findOrFail($id);

        return view('project', ['project' => $project]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Project::where('id', $id)->delete();

        return redirect()->back();
    }

    public function export(Project $project, Excel $excel)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $filename = 'urenregistratie_' . $project->name . '_' . now()->format('Y-m-d') . '.xlsx';

        return $excel->download(new ProjectExport($project), $filename);
    }
}
