<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'status' => 200,
            'data' => $request->user(),
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ], 200);
    }
}
