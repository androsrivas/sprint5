<?php

namespace App\Http\Controllers\APi\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $$this->validate($request, [
            'email' => 'requried|email',
            'password' => 'required|min:8',
        ]);

        $existingEmail = User::where('email', $request->email)->first();
        $existingNickname = User::where('nickname', $request->nickname);

        if ($existingEmail) {

            return response()->json([
                'message' => 'This email already exists.',
            ], 400);

        } else if ($existingNickname) {

            return response()->json([
                'message' => 'This nickname is already taken.',
            ], 400);

        } else {
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'nickname' => $request->name ?: 'anonymous-' . rand(100, 999),
            ]);
            $token = $user->createToken('LaravelPassportAuth')->accessToken;

            return response()
                ->json([
                    'message' => 'You have been registered successfully.',
                    'token' => $token,
                ], 200);
        }
    }

    public function loginUser(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelPassportAuth')->accessToken;
            
            return response()
                ->json([
                    'message' => 'Logged in successfully.',
                    'token' => $token,
                ], 200);

        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function userInfo()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }
}
