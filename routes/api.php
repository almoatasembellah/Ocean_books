<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookHeaderController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//ADMIN Login

Route::post('/admin/login', [AdminController::class, 'login']);
Route::middleware('api')->group(function () {

//General Routes
    Route::post('/book-header-delete/{id}', [BookHeaderController::class, 'destroy']);
    Route::resource('book-headers', BookHeaderController::class);
//Route::get('/get-book-headers', [BookHeaderController::class, 'index'])->name('book-headers');
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);//->middleware('admin')->except(['downloadBook','downloadVideo']);


//Download Routes
    Route::post('download-book', [BookController::class , 'downloadBook']);
    Route::post('download-video/{id}', [BookController::class , 'downloadVideo']);


//Serial Code Routes
    Route::post('generate-serial', [BookController::class, 'generateSerialCodes']);
    Route::get('generated', [BookController::class, 'generatedCodes']);

});
