<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UnitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}/edit', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/units/get-data', [UnitController::class, 'getData'])->name('unit.getData');

    Route::get('/product/import', [ProductController::class, 'showImportForm'])->name('product.show-import-form');
    Route::post('/product/import', [ProductController::class, 'import'])->name('product.import');
    Route::delete('/product/mass-delete', [ProductController::class, 'massDestroy'])->name('product.mass-destroy');

    Route::get('/unit/import', [UnitController::class, 'showImportForm'])->name('unit.show-import-form');
    Route::post('/unit/import', [UnitController::class, 'import'])->name('unit.import');
    Route::delete('/unit/mass-delete', [UnitController::class, 'massDestroy'])->name('unit.mass-destroy');
    Route::resource('unit', UnitController::class);

    Route::resource('project', ProjectController::class);
    Route::get('/project/{project}/overview', [ProjectController::class, 'overview'])->name('project.overview');
    Route::get('/project/{project}/package/{package}', [PackageController::class, 'show'])->name('project.package.show');
    Route::post('/project/{project}/package', [PackageController::class, 'store'])->name('project.package.store');
    Route::put('/project/{project}/package/{package}', [PackageController::class, 'update'])->name('project.package.update');
    Route::post('/project/{project}/subpackage', [PackageController::class, 'storeSubPackage'])->name('project.package.store-subpackage');
    Route::delete('/project/{project}/package/{package}', [PackageController::class, 'destroy'])->name('project.package.destroy');
    Route::delete('/project/{project}/subpackage/{package}', [PackageController::class, 'destroySubPackage'])->name('project.package.destroy-subpackage');

    Route::get('/project/{project}/tasks', [TaskController::class, 'index'])->name('project.package.task.index');
    Route::post('/project/{project}/task', [TaskController::class, 'store'])->name('project.package.task.store');
    Route::get('/project/{project}/task/{task}', [TaskController::class, 'show'])->name('project.package.task.show');
    Route::put('/project/{project}/task/{task}', [TaskController::class, 'update'])->name('project.package.task.update');
    Route::delete('/project/{project}/task/{task}', [TaskController::class, 'destroy'])->name('project.package.task.destroy');

    Route::post('/project/{project}/task/{task}/document', [TaskController::class, 'upload'])->name('project.package.task.document.store');
    Route::delete('/project/{project}/task/{task}/document/{document}', [TaskController::class, 'destroyDocument'])->name('project.package.task.document.destroy');
    Route::get('/task', [TaskController::class, 'index'])->name('task.index');
});

Route::get('/layouting', function () {
    return inertia('Layouting');
});
require __DIR__.'/auth.php';
