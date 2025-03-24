<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta para registrar un nuevo usuario
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    // Aquí irán tus rutas protegidas
    Route::apiResource('/users', UserController::class);

    // CRUD de compañías
    Route::apiResource('/companies', CompanyController::class);
});

