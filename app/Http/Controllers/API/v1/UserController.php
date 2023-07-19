<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()) {

            return UserResource::collection(User::all());
        } else {

            return response()->json([
                'message' => 'Unauthorised.'
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if (auth()->user()->id != $id) {

            return response()->json(['message' => 'Unauthorised.'], 401);
        }

        $user = User::findOrFail($id);
        $existingNickname = USer::where('nickname', $request->nickname)->get();

        if ($existingNickname) {

            return response()->json(['message' => 'This nickname already exists.'], 400);

        } else {
            
            $user->nickname = $request->nickname;
            $user->save();

            return response()->json([
                'message' => 'Nickname updated successfully.',
                'user' => UserResource::make($user),
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        /** @var \App\Models\User */
        $admin = auth()->user();

        if ($admin->hasRole('admin')) {

            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully.'], 200);
        } else {

            return response()->json(['message' => 'Unauthorised.'], 403);
        }
    }
}
