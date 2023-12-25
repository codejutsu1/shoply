<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return $this->success($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verified' => User::UNVERIFIED,
            'verification_token' => User::generateVerificationCode(),
            'admin' => User::REGULAR_USER,
        ]);

        return $this->success($users, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->success($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:8',
            'admin' => 'in:' . User::ADMIN . ',' . User::REGULAR_USER,
        ]);

        if($request->email && $user->email != $request->email)
        {
            $user->update([
                'verified' => User::UNVERIFIED,
                'verification_token' => User::generateVerificationCode(),
                'email' => $request->email
            ]);
        }

        if($request->has('admin')){
            if(!$user->isVerified()) return $this->error('Only verified users can modify the verified field', 409);

            $user->update([
                'admin' => $request->admin
            ]);
        }
        
        // if(!$user->isDirty()) return $this->error('You need to specify a different value to update', 422);

        $user->update([
            'name' => $request->name ?? $user->name,
            'password' => Hash::make($request->password),
        ]);

        return $this->success($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
