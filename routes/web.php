<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/login", [AuthController::class, 'showLogin'])->name('auth.login');
Route::get("/register", [AuthController::class, 'showRegister'])->name('auth.register');
Route::post("/register", [AuthController::class, 'processRegister'])->name('auth.processRegister');
Route::post("/login", [AuthController::class, 'processLogin'])->name('auth.processLogin');
Route::get("/dashboard", [DashboardController::class, 'index'])->name('dashboard.index');