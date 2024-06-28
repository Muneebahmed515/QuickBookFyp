<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Handle a request to get a user by email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByEmail(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'User Retrieved Successfully',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }
    }
}