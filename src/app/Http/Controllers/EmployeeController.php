<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
// use App\Http\Resources\employees\EmployeeResource;
use App\Http\Requests\employees\StoreEmployeeRequest;
use App\Http\Requests\employees\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{

    public function getEmployees()
    {
        try {
            $users = User::with('role')->where('role_id', 2)->get();
            return EmployeeResource::collection($users);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch employees', 'message' => $e->getMessage()], 500);
        }
    }
    public function addEmployee(StoreEmployeeRequest $request)
    {
        try {

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'username'   => $request->username,
                'email'      => $request->email,
                'role_id'    => 2,
                'password'   => $request->password,
            ]);
            $user->load('role');

            return response()->json([
                'message' => 'User created',
                'user' => [
                    'id'         => $user->id,
                    'first_name' => $user->first_name,
                    'last_name'  => $user->last_name,
                    'username'   => $user->username,
                    'email'      => $user->email,
                    'role'       => $user->role->name,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to add employee', 'message' => $e->getMessage()], 500);
        }
    }
    public function getEmployeeById($id)
    {
        try {
            $user = User::with('role')->where('role_id', 2)->findOrFail($id);
            return new EmployeeResource($user);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch employee', 'message' => $e->getMessage()], 500);
        }
    }
    public function updateEmployee(Request $request, $id)
    {
        try {
            $user = User::where('role_id', 2)->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'sometimes|required|string|max:255',
                'last_name'  => 'sometimes|required|string|max:255',
                'username'   => 'sometimes|required|string|unique:users,username,' . $id,
                'email'      => 'sometimes|required|email|unique:users,email,' . $id,
                'password'   => 'nullable|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user->update($request->only([
                'first_name',
                'last_name',
                'username',
                'email'
            ]));

            if ($request->filled('password')) {
                $user->password = $request->password;
                $user->save();
            }


            $user->load('role');

            return response()->json([
                'message' => 'User updated',
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role->name,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ]
            ]);


            return response()->json(['message' => 'User updated', 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update employee', 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteEmployee($id)
    {
        try {
            $user = User::where('role_id', 2)->findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'Admin deleted']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete employee', 'message' => $e->getMessage()], 500);
        }
    }
}
