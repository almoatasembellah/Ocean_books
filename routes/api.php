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


//User Routes
Route::get('/get-all-book-header',[BookHeaderController::class, 'bookHeadersToUser']);
Route::get('/get-all-categories',[CategoryController::class, 'index']);
Route::get('/get-all-books-for-users', [BookController::class, 'getAllBooksForUsers']);
Route::get('/get-books-for-headers',[BookHeaderController::class, 'getBooksByHeaderID']);
Route::get('/get-books-for-categories',[CategoryController::class, 'getBooksByCategoryId']);
Route::get('/get-book-for-id/{id}', [BookController::class, 'showSpecificBook']);

//Download Routes
Route::post('download-book', [BookController::class , 'downloadBook']);
Route::post('download-video/{id}', [BookController::class , 'downloadVideo']);


Route::middleware(['auth:sanctum'])->group(function () {
//BookHeaders Routes
    Route::middleware('role:admin')->group(function () {

    Route::post('/book-header-delete/{id}', [BookHeaderController::class, 'destroy']);
    Route::get('/book-headers', [BookHeaderController::class, 'index']);
    Route::post('/book-headers', [BookHeaderController::class, 'store']);
    Route::get('/book-headers/{id}', [BookHeaderController::class, 'show']);
    Route::put('/book-headers/{id}', [BookHeaderController::class, 'update']);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    });


//Serial Code Routes
    Route::post('generate-serial', [BookController::class, 'generateSerialCodes']);
    Route::get('generated', [BookController::class, 'generatedCodes']);
    Route::post('get-generated-specific', [BookController::class, 'specificGeneratedCode']);

});


Route::post('admin/logout', [AdminController::class, 'adminLogout'])->middleware('auth:sanctum')->name('logout');
