<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/unit/create', [UnitController::class, 'store'])->name('api.unit.store');
Route::middleware('auth:sanctum')->get('/products', [ProductController::class, 'index'])->name('api.product.index');
Route::middleware('auth:sanctum')->get('/projects', [ProjectController::class, 'index'])->name('api.project.index');
Route::middleware('auth:sanctum')->get('/task/{task}', [TaskController::class, 'getTask'])->name('api.task.get-task');
