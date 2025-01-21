<?php


// dashboard routes

use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\ConstantController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\UserController;

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '',
    'middleware' => ['auth'],
    'as' => 'dashboard.'
], function () {
    /* ********************************************************** */ 

    // Dashboard ************************
    Route::get('/', function () {return view('dashboard.index');})->name('home');

    // Logs ************************
    Route::get('logs',[ActivityLogController::class,'index'])->name('logs.index');
    Route::get('getLogs',[ActivityLogController::class,'getLogs'])->name('logs.getLogs');

    // users ************************
    Route::get('profile/settings',[UserController::class,'settings'])->name('profile.settings');

    /* ********************************************************** */ 



    /* ********************************************************** */

    // Resources

    Route::resource('constants', ConstantController::class)->only(['index','store','destroy']);
    Route::resource('currencies', CurrencyController::class)->except(['show','edit','create']);


    Route::resources([
        'users' => UserController::class,
    ]);
    /* ********************************************************** */ 
});