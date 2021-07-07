<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\loginUserRequest;
use App\Http\Requests\user\storeUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerUser(storeUserRequest $req)
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = bcrypt($req->password);
        $user->save();

        $token = null;
        if ($user) {
            $token = $user->createToken('allAccessToken')->plainTextToken;
        }

        return response()->json([
            "user" => $user,
            "token" => $token
        ], 201);
    }


    public function loginUser(loginUserRequest $req)
    {
        $user = User::where('email', $req->email)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                "message" => "User email or password not match."
            ], 401);
        }

        // before creating new token delete all old active token of user so no 
        // any old token stays valid
        $user->tokens()->delete();

        $token = $user->createToken('allAccessToken')->plainTextToken;

        return response()->json([
            "user" => $user,
            "token" => $token
        ], 200);
    }

    public function logoutUser()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'msg' => 'success fully log out.'
        ], 200);
    }
}
