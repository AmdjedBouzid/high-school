<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function insertAdmin(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);
            $superAdminRole = Role::where('name', 'super-admin')->first();
            if (!$superAdminRole) {
                return response()->json(['error' => 'Super admin role not found.'], 400);
            }
            $existingSuperAdmin = User::where('role_id', $superAdminRole->id)->first();
            if ($existingSuperAdmin) {
                return response()->json(['error' => 'A super admin already exists.'], 400);
            }
            $admin = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'role_id' => $superAdminRole->id,
            ]);
            $admin->password = $request->password;
            $admin->save();

            return response()->json(['message' => 'Admin user created successfully!', 'admin' => $admin], 201);
        } catch (\Exception $e) {
            Log::error('Error creating super admin: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while creating the admin.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
     public   function getProfile(Request $request) {
        try {
            return response()->json([$request->user()]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
