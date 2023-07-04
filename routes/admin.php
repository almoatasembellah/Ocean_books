<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookHeaderController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

//General Routes
Route::resource('book-headers', BookHeaderController::class);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);//->middleware('auth:admin');


//Download Routes
Route::post('download-book', [BookController::class , 'downloadBook']);
Route::post('download-video/{id}', [BookController::class , 'downloadVideo']);


//Serial Code Routes
Route::post('generate-serial', [BookController::class, 'generateSerialCodes']);
Route::get('generated', [BookController::class, 'generatedCodes']);

