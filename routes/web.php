<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view("/", "form_page")->name('form_page');

// CRUD routes for the User model
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::put('/users/{id}/update', [UserController::class, 'update']);
Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/checkEmail', [UserController::class, 'checkEmail']);

?>