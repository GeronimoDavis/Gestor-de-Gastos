<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

//rutas accesibles solo para usuarios no autenticados

Route::middleware('guest')->group(function (){
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

});

//Rutas protegidas solo para usuarios autenticados

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', function(){
        return view('dashboard');
    })->name('dashboard');

   Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

   //rutas de categorias 
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories', [CategoryController::class, 'destroy'])->name('categories.destroy');

});