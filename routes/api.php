<?php

use App\Http\Controllers\Admin\BorrowRecordsController as AdminBorrowRecordsController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\BookController as CustomerBookController;
use App\Http\Controllers\Customer\BorrowRecordsController as CustomerBorrowRecordsController;
use App\Http\Controllers\Customer\RatingController as CustomerRatingController;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

Route::middleware('auth:api')->group(function () {
    Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware('auth:api')->prefix('admin')->group(function () {
    Route::apiResource('users', UserController::class)->except(['store', 'update']);
    Route::post('/users/{user}/block', [UserController::class, 'blockUser']);
    Route::post('/users/{user}/unBlock', [UserController::class, 'unBlockUser']);
    Route::get('/blockUsers', [UserController::class, 'blockUsers']);
    Route::get('/unBlockUsers', [UserController::class, 'unBlockUsers']);
    Route::apiResource('books', AdminBookController::class);
    Route::get('/allCategory', [AdminBookController::class, 'allCategory']);
    Route::apiResource('books.borrowRecords', AdminBorrowRecordsController::class)->except(['store']);
    Route::delete('/books/{book}/borrowRecords', [AdminBorrowRecordsController::class, 'destroyAll']);
    Route::apiResource('books.ratings', AdminRatingController::class)->only(['index', 'show']);
});

Route::prefix('customer')->group(function () {
    Route::apiResource('books', CustomerBookController::class)->only(['index', 'show']);
    Route::get('/allCategory', [CustomerBookController::class, 'allCategory']);
    Route::middleware('auth:api')->apiResource('books.borrowRecords', CustomerBorrowRecordsController::class)->except(['destroy', 'update']);
    Route::middleware('auth:api')->apiResource('books.ratings', CustomerRatingController::class);
});
