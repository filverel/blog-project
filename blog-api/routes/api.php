<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostIndexController;
use App\Http\Controllers\Admin\PostIndexController as AdminPostIndexController;
use App\Http\Controllers\PostShowController;

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

Route::get('/posts', PostIndexController::class);
Route::get('/posts/{post:slug}', PostShowController::class);
Route::get('/admin/posts', AdminPostIndexController::class);
