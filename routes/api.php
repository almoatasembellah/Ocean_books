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

//ADMIN Auth
Route::post('admin/login', [AdminController::class, 'login'])->name('login');
Route::post('admin/logout', [AdminController::class, 'adminLogout'])->middleware('auth:sanctum')->name('logout');


//User Routes
Route::get('/get-all-book-header',[BookHeaderController::class, 'bookHeadersToUser']);
Route::get('/get-all-categories',[CategoryController::class, 'index']);
Route::get('/get-all-books',[BookController::class, 'getBooks']);

//Download Routes
Route::post('download-book', [BookController::class , 'downloadBook']);
Route::post('download-video/{id}', [BookController::class , 'downloadVideo']);


Route::middleware(['auth:sanctum'])->group(function () {
//BookHeaders Routes
    Route::middleware('role:admin')->group(function () {

    Route::post('/book-header-delete/{id}', [BookHeaderController::class, 'destroy']);
    Route::resource('book-headers', BookHeaderController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    });


//Serial Code Routes
    Route::post('generate-serial', [BookController::class, 'generateSerialCodes']);
    Route::get('generated', [BookController::class, 'generatedCodes']);

});
