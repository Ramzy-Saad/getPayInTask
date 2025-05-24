<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::patch('/update-profile', [AuthController::class, 'update_profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
