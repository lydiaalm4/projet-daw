<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class project extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all(); // Fetch all projects
    return response()->json($projects, 200); // Return projects as JSON
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view for creating a project (if required)
    return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|in:pending,active,assigned,completed',
        'teacher_id' => 'required|exists:users,id', // Assuming teacher is a user
    ]);

    // Create the project
    $project = Project::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'status' => $validated['status'],
        'teacher_id' => $validated['teacher_id'],
    ]);

    return response()->json($project, 201); // Return the created project
    }

    /**
     * Display the specified resource.
     */
    public function show(project $project)
    {
        // If you need to load related data (e.g., teacher, students), use `load`:
    $project->load('Teacher', 'Students'); // Assuming relationships exist

    return response()->json($project, 200); // Return the project with related data
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(project $project)
    {
         // Return a view for editing the project (if required)
    return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, project $project)
    {
         // Validate incoming request data
    $validated = $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'status' => 'sometimes|string|in:pending,active,assigned,completed',
        'teacher_id' => 'sometimes|exists:users,id',
    ]);

    // Update the project details
    $project->update([
        'title' => $validated['title'] ?? $project->title,
        'description' => $validated['description'] ?? $project->description,
        'status' => $validated['status'] ?? $project->status,
        'teacher_id' => $validated['teacher_id'] ?? $project->teacher_id,
    ]);

    return response()->json($project, 200); // Return the updated project
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(project $project)
    {
        $project->delete(); // Delete the project
        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
