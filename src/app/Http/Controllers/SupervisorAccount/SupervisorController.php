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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supervisors = User::with(['supervisorInfo', 'role'])
            ->whereHas('role', function ($q) {
                $q->where('name', 'supervisor');
            })->get();

        return SupervisorResource::collection($supervisors);
    }

    /**
     * Store a newly created resource in storage.
     */
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


    /**
     * Display the specified resource.
     */
    public function show(User $supervisor)
    {
        return new SupervisorResource($supervisor->load(['supervisorInfo', 'role']));
    }

    // ! Checked
    public function profile(Request $request)
    {
        return new SupervisorResource($request->user()->load(['supervisorInfo', 'role']));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
