<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*===========================
=           categories           =
=============================*/

Route::apiResource('/categories', \App\Http\Controllers\API\CategoryController::class);

/*=====  End of categories   ======*/

/*===========================
=           posts           =
=============================*/

Route::apiResource('/posts', \App\Http\Controllers\API\PostController::class);

/*=====  End of posts   ======*/
