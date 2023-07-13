<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'email' => 'required|email|max:35',
            'password' => 'required|string|min:8',
            'nickname' => 'nullable|string|min:3|max:10',
        ]);
        
        if ( $validator->fails()) {

            return response()->json(['errors' => $validator->errors()->all()], 422);

        }

        $emailExists = User::where('email', $request->email)->first();
        $nicknameExists = User::where('nickname', 'LIKE', $request->nickname)->first();

        if($emailExists) {
            
            return response()->json([
                'message' => 'This email already exists.',
            ], 400);

        } else if ($nicknameExists) {

            return response()->json([
                'message' => 'This nickname is already taken.',
            ], 400);

        } else {

        $user = User::create([
            'nickname' => $request->nickname ?: 'anonymous-' . rand(100,999),
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10), 
        ]);

        $accessToken = $user->createToken('register')->accessToken;

        return response()
            ->json([
                'message' => 'You have been registered successfully.',
                'user' => $user,
                'access_token' => $accessToken,
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {

            $token = auth()->user()->createToken('login')->accessToken;
            
            return response()
                ->json([
                    'message' => 'Logged in successfully.',
                    'user' => Auth::user(),
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
