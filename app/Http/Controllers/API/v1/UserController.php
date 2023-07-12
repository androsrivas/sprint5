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
        return UserResource::collection(User::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if (auth()->user()->id != $id ) {
            return response()->json(['message' => 'Access denied.'], 401);
        }

        $user = User::findOrFail($id);
        $user->nickname = $request->nickname;

        return response()->json([
            'message' => 'Nickname updated successfully.',
            'user' => UserResource::make($user),
        ], 200);       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // if ( auth()->user()->hasRole('admin')) {
        //     $user = User::findOrFail($id);
        //     $user->delete();

        //     return response()->json(['message' => 'User deleted successfully.'], 200);
        // } else {
        //     return response()->json(['message' => 'Unauthorised.'], 401);
        // }
    }
}
