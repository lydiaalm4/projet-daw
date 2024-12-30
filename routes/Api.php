<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\AdminUserController;

Route::post('/admin/users', [AdminUserController::class, 'createUser']); // Create user
Route::put('/admin/users/{id}', [AdminUserController::class, 'updateUser']); // Update user
Route::delete('/admin/users/{id}', [AdminUserController::class, 'deleteUser']); // Delete user
Route::patch('/admin/users/{id}/status', [AdminUserController::class, 'toggleUserStatus']); // Activate/deactivate user
Route::get('/admin/users/{id}', [AdminUserController::class, 'viewUser']); // View user details
Route::get('/admin/users', [AdminUserController::class, 'listUsers']); // List all users