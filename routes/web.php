<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FinancialRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubuserController;


Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('checkauth')->name('logout');

Route::middleware('checkauth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/api/dashboard-data', [FinancialRecordController::class, 'dashboard'])->name('api.dashboard');
    Route::resource('role', RoleController::class);
    Route::resource('subusers', SubuserController::class);
    Route::resource('posts', PostController::class);
    Route::resource('records', FinancialRecordController::class);
});
