<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//rutas accesibles solo para usuarios no autenticados

Route::middleware('gust')->group(function (){
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('register')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

});

//Rutas protegidas solo para usuarios autenticados

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', function(){
        return view('dashboard');
    })->name('dashboard');

   Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});