<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the add user form
     */
    public function addUser()
    {
        // Define available roles for the form (could come from database in real application)
        $roles = [
            'pharmacist' => 'Pharmacist',
            'doctor' => 'Doctor', 
            
        ];
        return view('dashboard.forms.addUser', compact('roles'));
    }

    /**
     * Store a new user
     */
    public function addUserPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|string|in:pharmacist,doctor',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_verified' => 1,
        ]);

        return redirect()->route('dashboard.users')->with('success', 'User added successfully.');
    }

    /**
     * Delete a user
     */
    public function deleteUsers($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Verify user password
     */
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $user = auth()->user();

        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Password verified successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password. Please try again.'
            ], 422);
        }
    }

    /**
     * Get a single user by ID
     */
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Update user information
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $rules = [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|in:pharmacist,doctor',
        ];
        
        // Only validate password if it's being updated
        if ($request->has('password') && $request->password) {
            $rules['password'] = 'min:8';
        }
        
        $request->validate($rules);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        if ($request->has('password') && $request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return response()->json([
            'message' => 'User updated successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ]);
    }
}
