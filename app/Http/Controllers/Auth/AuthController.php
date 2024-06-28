<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        if(!Auth::once($request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'device_id' => 'required'
        ]))){
            return $this->errorResponse('Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        $accessToken = $user->createToken('Api Token Of User '.$user->name, ['*'], now()->addWeek(),9)->plainTextToken;
        return $this->successResponse(['data' => ['access_token'=> $accessToken]], 200);
    }

    public function register(Request $request)
    {
        $user = User::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]));
        $user->verified = User::UNVERIFIED_USER;
        $user->verification_token = User::generateVerificationCode();
        $user->admin = User::REGULAR_USER;
        $user->save();
        $accessToken = $user->createToken('Api Token Of User '.$user->name)->plainTextToken;
        $user = $this->transformData($user,$user->transformer);
        return $this->successResponse([
            'user'=>$user,
            'access_token' => $accessToken,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse([
            'message'=> 'You logging out'
        ], 201);
    }
}
