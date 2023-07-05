<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    public function signUp(Request $request)
    {
        $userValidation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'location' => 'required',
            'phone' => 'required'
        ]);
        if ($userValidation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $userValidation->errors()
            ], 422);
        }
        $userData = $userValidation->validated();
        $user = Users::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'location' => $userData['location'],
            'phone' => $userData['phone']
        ]);
        return response()->json(['success' => true], 200);
    }

    public function signIn(Request $request)
    {
        $checkCredentials = $request->only('email', 'password');
        if ($token = Auth::guard('api')->attempt($checkCredentials)) {
            return response()->json(['success' => true, 'token' => $token], 200);
        }
        return response()->json(['success' => false, 'message' => 'Wrong credentials'], 401);
    }
}