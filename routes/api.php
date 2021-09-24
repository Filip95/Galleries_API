<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserGalleriesController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/me', [AuthController::class, 'getMyProfile'])->middleware('auth');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refreshToken'])->middleware('auth');
});

Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{gallery}',[GalleryController::class,'showSingleGallery']);
Route::delete('/galleries/{gallery}',[GalleryController::class, 'destroy']);
Route::put('/edit-gallery/{gallery}', [GalleryController::class, 'update']);
Route::get('/my-galleries/{user_id}', [GalleryController::class, 'showMyGalleries']);
Route::post('/create-gallery', [GalleryController::class, 'store']);

Route::get('/authors/{user_id}',[UserGalleriesController::class, 'show']);

Route::delete('galleries/{gallery}/comments/{comment}',[CommentController::class, 'destroy']);
Route::post('/galleries/{gallery}/comments', [CommentController::class, 'store']);



