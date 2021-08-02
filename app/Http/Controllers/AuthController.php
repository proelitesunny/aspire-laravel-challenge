<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try{
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
        }
        catch(\Exception $e){
            logger()->error($e->getMessage());
            return response()->json(['message' => 'Some error occured'], 400);
        }

        return [
            'token' => $user->createToken('app_api')->plainTextToken,
            'message' => 'Success',
            'user' => $user
        ];
    }

    public function login(LoginRequest $request){
        $user = User::where('email', $request->get('email'))->first();

        if (! $user || ! Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'token' => $user->createToken('app_api')->plainTextToken,
            'message' => 'Success',
            'user' => $user
        ];
    }

    public function logout(LogoutRequest $request){
        try{
            $request->user()->currentAccessToken()->delete();
        }
        catch(\Exception $e){
            logger()->error($e->getMessage());
            return response()->json(['message' => 'Some error occured'], 400);
        }
        return [
            'message' => 'You have been logged out successfully',
        ];
    }
}
