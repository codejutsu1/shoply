<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['store', 'resend']]);

        $this->middleware('transform.input:' . UserCollection::class)->only(['store', 'update']);
    }

    public function index()
    {
        $users = User::all();

        return $this->success(new UserCollection($users));
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

        return $this->success(new UserResource($users), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->success(new UserResource($user));
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

        return $this->success(new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->success(new UserResource($user));
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->update([
            'verified' => User::VERIFIED,
            'verification_token' => null
        ]);

        return $this->message('The account has been verified successfully.');
    }

    public function resend(User $user)
    {
        if($user->isVerified()) return $this->error('This user is verified', 409);

        retry(5, function() use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->message('Verification link has been sent to ' . $user->email);
    }

    // protected function sortBy($collection)
    // {
    //     return $this->sortData($collection);
    // }
}
