<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
     /**
     * Create a new user (teacher or student).
     */
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'type' => 'required|in:teacher,student', // User type
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => $validated['type'],
            'is_active' => true, // Default active status
        ]);

        return response()->json($user, 201);
    }

    /**
     * Update an existing user account.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'type' => 'sometimes|in:teacher,student',
        ]);

        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password,
            'type' => $validated['type'] ?? $user->type,
        ]);

        return response()->json($user);
    }

    /**
     * Delete a user account.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    /**
     * Activate or deactivate a user account.
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = !$user->is_active; // Toggle the activation status
        $user->save();

        return response()->json([
            'message' => $user->is_active ? 'User activated' : 'User deactivated',
            'status' => $user->is_active ? 'Active' : 'Inactive',
        ]);
    }

    /**
     * View details of a specific user.
     */
    public function viewUser($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /**
     * List all users with details (teachers and students).
     */
    public function listUsers(Request $request)
    {
        $type = $request->query('type'); // Filter by user type (optional)
        $users = User::when($type, fn($query) => $query->where('type', $type))->get();

        return response()->json($users);
    }
}
