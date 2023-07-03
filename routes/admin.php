<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Api\BookHeaderController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

//apis controller
Route::resource('book-headers', BookHeaderController::class);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);
Route::post('download-book', [BookController::class , 'download']);
Route::post('generate-serial', [BookController::class, 'generateSerialCodes']);
Route::get('generated', [BookController::class, 'generatedCodes']);


//web controller
Route::resource('library', AdminBookController::class);
