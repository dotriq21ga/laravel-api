<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:App\Models\User,name',
                'email' => 'email|unique:App\Models\User,email',
                'password' => 'required',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Success",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => $th->getMessage(),
            ], 404);
        }
    }
}
