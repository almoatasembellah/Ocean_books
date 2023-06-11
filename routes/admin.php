<?php

use App\Http\Controllers\Api\BookHeaderController;
use Illuminate\Support\Facades\Route;

Route::resource('book-headers' , BookHeaderController::class);
Route::resource('categories' , \App\Http\Controllers\Api\CategoryController::class);
Route::resource('books' , \App\Http\Controllers\Api\BookController::class);



