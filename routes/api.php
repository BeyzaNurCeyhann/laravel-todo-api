<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\AuthController;

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

/*
Route::get('/todos', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Todo endpoint aktif!'
    ]);
});
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});


Route::middleware(['auth:api', 'throttle:api'])->group(function () {

    Route::prefix('todos')->group(function () {
        Route::get('/', [TodoController::class, 'index']);
        Route::get('/search', [TodoController::class, 'search']);
        Route::get('/{id}', [TodoController::class, 'show']);
        Route::post('/', [TodoController::class, 'store']);
        Route::put('/{id}', [TodoController::class, 'update']);
        Route::patch('/{id}/status', [TodoController::class, 'updateStatus']);
        Route::delete('/{id}', [TodoController::class, 'destroy']);
    });


    Route::prefix('categories')->middleware('auth:api')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);

        Route::middleware('role:admin')->group(function () {
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
            Route::get('/{id}/todos', [CategoryController::class, 'todos']);
        });
    });

    Route::prefix('stats')->group(function () {
        Route::get('/todos', [StatController::class, 'todos']);
        Route::get('/priorities', [StatController::class, 'priorities']);
    });
});
