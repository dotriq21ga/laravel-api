<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        try {

            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 404,
                    'message' => 'The provided credentials do not match'
                ], 404);
            }

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 200,
                'access_token' => $tokenResult,
            ], 200);
            
        } catch (\Exception $error) {

            return response()->json([
                'status' => 404,
                'message' => 'Error in Login',
                'error' => $error,
            ], 404);
        }
    }
}
