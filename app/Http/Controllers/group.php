<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class group extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupes = Groupe::all(); // Fetch all groups
        return response()->json($groupes, 200); // Return groups as JSON
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view for creating a group (if required)
    return view('groupes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'members' => 'required|array|min:1', // Members must be an array
        'members.*' => 'exists:users,id',   // Each member must exist in the users table
    ]);

    // Create the group
    $groupe = Groupe::create([
        'name' => $validated['name'],
    ]);

    // Attach members to the group (assuming a many-to-many relationship)
    $groupe->members()->sync($validated['members']);

    return response()->json($groupe, 201); // Return the created group
    }

    /**
     * Display the specified resource.
     */
    public function show(Groupe $groupe)
    {
        // Load related members (if applicable)
    $groupe->load('members'); // Assuming a relationship exists

    return response()->json($groupe, 200); // Return the group with its members
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groupe $groupe)
    {
        // Return a view for editing the group (if required)
    return view('groupes.edit', compact('groupe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Groupe $groupe)
    {
        // Validate incoming request data
    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'members' => 'sometimes|array|min:1',
        'members.*' => 'exists:users,id',
    ]);

    // Update group details
    $groupe->update([
        'name' => $validated['name'] ?? $groupe->name,
    ]);

    // Update members if provided
    if (isset($validated['members'])) {
        $groupe->members()->sync($validated['members']);
    }

    return response()->json($groupe, 200); // Return the updated group
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groupe $groupe)
    {
        $groupe->delete(); // Delete the group
        return response()->json(['message' => 'Group deleted successfully'], 200);
    }
}
