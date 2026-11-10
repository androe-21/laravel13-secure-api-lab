<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Profile
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
        ]);
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Students: Admin and Student access
    Route::get('/students', function () {
        return response()->json([
            'message' => 'Students list retrieved successfully.',
            'students' => User::where('role', 'student')
                ->get(['id', 'name', 'email', 'role']),
        ]);
    })->middleware('role:admin,student');

    // Admin dashboard
    Route::get('/admin/dashboard', function () {
        return response()->json([
            'message' => 'Welcome to the Admin Dashboard.',
        ]);
    })->middleware('admin');

    // Student dashboard
    Route::get('/student/dashboard', function () {
        return response()->json([
            'message' => 'Welcome to the Student Dashboard.',
        ]);
    })->middleware('role:student');

});