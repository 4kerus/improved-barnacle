<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use App\Helpers\ApiResponse;

Route::prefix('v1')->group(function () {

    Route::get('example', function () {
        return ApiResponse::success([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ], 'User retrieved successfully');
    });

    Route::get('error', function () {
        return ApiResponse::error('User not found', 404);
    });

    Route::apiResource('users', UserController::class);

});
