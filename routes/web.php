<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', function () {
        // Redirect to /
        return redirect('/templates');
    });

    Route::get('/home', function() {
        // Redirect to /
        return redirect('/templates');
    });

    Route::prefix('templates')->group(function () {
        Route::get('/', [TemplateController::class, 'index'])->name('templates.index');

        Route::get('/create', [TemplateController::class, 'create'])->middleware('can:create templates')->name('templates.create');

        Route::post('/', [TemplateController::class, 'store'])->middleware('can:create templates')->name('templates.store');

        Route::get('/{id}', [TemplateController::class, 'show'])->middleware('can:read templates')->name('templates.show');

        Route::put('/{id}', [TemplateController::class, 'update'])->middleware('can:update templates')->name('templates.update');

        Route::delete('/{id}', [TemplateController::class, 'destroy'])->middleware('can:delete templates')->name('templates.destroy');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('can:read users')->name('users.index');
        Route::get('/{id}', [UserController::class, 'show'])->middleware('can:read users')->name('users.show');
        Route::put('/{id}', [UserController::class, 'update'])->middleware('can:update users')->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('can:delete users')->name('users.destroy');
    });

    Route::prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->middleware('can:read groups')->name('groups.index');
        Route::get('/create', [GroupController::class, 'create'])->middleware('can:create groups')->name('groups.create');
        Route::get('/{id}', [GroupController::class, 'show'])->middleware('can:read groups')->name('groups.show');
        Route::put('/{id}', [GroupController::class, 'update'])->middleware('can:update groups')->name('groups.update');
        Route::delete('/{id}', [GroupController::class, 'destroy'])->middleware('can:delete groups')->name('groups.destroy');
    });

    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/create', [ScheduleController::class, 'create'])->middleware('can:create schedules')->name('schedules.create');
        Route::post('/', [ScheduleController::class, 'store'])->middleware('can:create schedules')->name('schedules.store');
        Route::get('/{id}', [ScheduleController::class, 'show'])->middleware('can:read schedules')->name('schedules.show');
        Route::put('/{id}', [ScheduleController::class, 'update'])->middleware('can:update schedules')->name('schedules.update');
        Route::delete('/{id}', [ScheduleController::class, 'destroy'])->middleware('can:delete schedules')->name('schedules.destroy');
    });

    Route::prefix('logs')->middleware('can:read logs')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('logs.index');
    });
});

Auth::routes();


