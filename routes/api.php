<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\CategoryController;


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

Route::prefix('todos')->group(function () {

    Route::get('/', [TodoController::class, 'index']); // Tüm todo'ları listele
    Route::get('/search', [TodoController::class, 'search']); // Arama
    Route::get('/{id}', [TodoController::class, 'show']); // Tek todo getir
    Route::post('/', [TodoController::class, 'store']); // Yeni todo
    Route::put('/{id}', [TodoController::class, 'update']); // Güncelleme
    Route::patch('/{id}/status', [TodoController::class, 'updateStatus']); // Durum güncelle
    Route::delete('/{id}', [TodoController::class, 'destroy']); // Silme (soft delete)

});

Route::prefix('categories')->group(function () {

    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
