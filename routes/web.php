<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{product}/edit', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('/product/unit', [UnitController::class, 'index'])->name('unit.index');
Route::get('/product/unit/create', [UnitController::class, 'create'])->name('unit.create');
Route::post('/product/unit/create', [UnitController::class, 'store'])->name('unit.store');
Route::get('/product/unit/getData', [UnitController::class, 'getData'])->name('unit.getData');
Route::get('/product/unit/{unit}/edit', [UnitController::class, 'edit'])->name('unit.edit');
