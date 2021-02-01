<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\WorkerController;
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

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/baseon', [PageController::class, 'index']);
    
    Route::group(['prefix' => 'todos'], function() {
        Route::post('/store', [TodoController::class, 'store']);
        Route::post('/updatetodos', [TodoController::class, 'update']);
        Route::post('/changetodos', [TodoController::class, 'changetodos']);
    });
    
    Route::group(['prefix' => 'groups'], function() {
        Route::get('/', [GroupController::class, 'index']);
        Route::post('/create', [GroupController::class, 'create']);
        Route::post('/update', [GroupController::class, 'update']);
        Route::post('/clear', [GroupController::class, 'clear']);
    });
    
    Route::group(['prefix' => 'workers'], function() {
        Route::get('/', [WorkerController::class, 'index']);
        Route::post('/create', [WorkerController::class, 'create']);
    });
});


Route::middleware(['auth:sanctum', 'verified', 'iam_admin'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
