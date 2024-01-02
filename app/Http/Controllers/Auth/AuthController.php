<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {   
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verified' => User::UNVERIFIED,
            'verification_token' => User::generateVerificationCode(),
            'admin' => User::REGULAR_USER,
        ]);

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        return $this->success([new UserResource($user), 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid Login Details', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        return $this->success([new UserResource($user), 'token' => $token], 200);

    }
}
