<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        // Create the user
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'fullName' => $request->firstName . ' ' . $request->lastName, // assuming fullName is a combination of firstName and lastName
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // Return the created user
        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Signup Successful',
            'data' => $user
        ], 201);
    }


    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        // Check credentials manually
        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Login Successful',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid Credentials',
                'data' => null
            ], 401);
        }
    }
}
