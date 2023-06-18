<?php

use App\Http\Controllers\Api\AdminLoginController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookHeaderController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'auth.'], function () {
    Route::get('login', [AdminLoginController::class, 'login'])->name('login');
    Route::post('login', [AdminLoginController::class, 'submit'])->name('login.submit');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth:admin']], function () {
});

Route::resource('book-headers', BookHeaderController::class);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);
Route::post('download-book', [BookController::class , 'download']);


