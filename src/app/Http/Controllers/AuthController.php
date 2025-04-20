<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    public function login(loginRequest $request)
    {
        $user = User::where('email', $request->login)
            ->whereNull('deleted_at')
            ->orWhere('username', $request->login)
            ->with(['role:id,name'])
            ->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->role_id == 1) {
            $abilities = ['crud-employees', 'crud-supervisor'];
        } elseif ($user->role_id == 2) {
            $abilities = ['crud-supervisor'];
        } elseif ($user->role_id == 3) {
            $abilities = [];
        } else {
            $abilities = [];
        }

        $token = $user->createToken(
            $request->userAgent() ?? 'api-token',
            $abilities
        )->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => new UserResource($user)
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
