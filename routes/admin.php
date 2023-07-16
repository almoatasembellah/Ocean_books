<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookHeaderController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

//ADMIN Login
Route::post('/admin/login', [AdminController::class, 'login']);

//General Routes
Route::resource('book-headers', BookHeaderController::class);//->middleware('admin')->except(['index','show']);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);//->middleware('admin')->except(['downloadBook','downloadVideo']);


//Download Routes
Route::post('download-book', [BookController::class , 'downloadBook']);
Route::post('download-video/{id}', [BookController::class , 'downloadVideo']);


//Serial Code Routes
Route::post('generate-serial', [BookController::class, 'generateSerialCodes']);
Route::get('generated', [BookController::class, 'generatedCodes']);

