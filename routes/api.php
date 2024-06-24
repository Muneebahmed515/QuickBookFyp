<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello World']);
});

Route::get('/test-db', function (Request $request) {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Database connection successfully established.']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to connect to the database: ' . $e->getMessage()], 500);
    }
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
