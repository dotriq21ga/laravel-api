<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\SliderController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [RegisterController::class, 'index']);
Route::post('/login', [LoginController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/album/{id}', [AlbumController::class, 'show']);
Route::get('/song/{id}', [SongController::class, 'show']);
Route::post('/search', [HomeController::class, 'search']);

/* test */
Route::post('/add_slider', [SliderController::class, 'create']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/like/{id}', [SongController::class, 'like']);

    Route::get('/album/detail/{id}', [AlbumController::class, 'show']);

    //chỉ mới test api 
    Route::post('/add_song', [SongController::class, 'create']);
    Route::post('/add_album', [AlbumController::class, 'create']);
});
