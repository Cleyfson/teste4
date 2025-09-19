<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
});


Route::prefix('movies')->middleware('auth:api')->group(function () {
    Route::get('search', [MovieController::class, 'search'])->name('movies.search');
    Route::get('genres', [MovieController::class, 'genres'])->name('movies.genres');
});

Route::prefix('favorites')->middleware('auth:api')->group(function () {
    Route::post('/', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');
});