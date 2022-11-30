<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SourceScrapingController;
use Illuminate\Http\Request;
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

// API route for register new user
Route::post('/register', [AuthController::class, 'register']);
// Api route for login user
Route::post('/login', [AuthController::class, 'login']);

// Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    Route::resource('/source-scraping', SourceScrapingController::class);

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});