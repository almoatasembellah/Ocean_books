<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookHeaderController;
use App\Http\Controllers\Api\CategoryController;
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
Route::post('admin/login', [AdminController::class, 'login'])->name('login');


//User Routes
//Route::middleware('auth:sanctum')->group(function () {
//    Route::get('user/book-header',[BookHeaderController::class, 'index']);
//});

//Admin routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

//BookHeaders Routes
    Route::middleware('role:admin')->group(function () {

    Route::post('/book-header-delete/{id}', [BookHeaderController::class, 'destroy']);
    Route::resource('book-headers', BookHeaderController::class);
//Route::get('/get-book-headers', [BookHeaderController::class, 'index'])->name('book-headers');
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    });


//Download Routes
    Route::post('download-book', [BookController::class , 'downloadBook']);
    Route::post('download-video/{id}', [BookController::class , 'downloadVideo']);


//Serial Code Routes
    Route::post('generate-serial', [BookController::class, 'generateSerialCodes']);
    Route::get('generated', [BookController::class, 'generatedCodes']);

});
