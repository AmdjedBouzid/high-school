<?php

namespace App\Http\Controllers\SupervisorAccount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupervisorInfo;
use Illuminate\Http\Response;
use App\Http\Requests\SupervisorCreateRequest;
use App\Http\Requests\SupervisorUpdateRequest;
use App\Http\Resources\SupervisorResource;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisors = User::with(['supervisorInfo', 'role', "students"])
            ->whereHas('role', function ($q) {
                $q->where('name', 'supervisor');
            })->get();

        return SupervisorResource::collection($supervisors);
    }

    public function store(SupervisorCreateRequest $request)
    {

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 3,
        ]);

        SupervisorInfo::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'sexe' => $request->sexe,
        ]);

        $user->load(['supervisorInfo', 'role']);

        return new SupervisorResource($user);
    }


    public function show(User $supervisor)
    {
        return new SupervisorResource($supervisor->load(['supervisorInfo', 'role']));
    }

    public function profile(Request $request)
    {
        return new SupervisorResource($request->user()->load(['supervisorInfo', 'role']));
    }

    public function update(SupervisorUpdateRequest $request, User $supervisor)
    {
        $supervisor->update($request->validated());
        if ($request->has('supervisor_info')) {
            $supervisor->supervisorInfo()->updateOrCreate(
                ['user_id' => $supervisor->id],
                $request->input('supervisor_info')
            );
        }
        return new SupervisorResource($supervisor->load(['role', 'supervisorInfo']));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'Supervisor deleted successfully.'
        ], 204);
    }
}
