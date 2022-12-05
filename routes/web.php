<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScraperController;
use App\Http\Livewire\SourceScrapingLivewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scraper-prosple', [ScraperController::class, 'prosple']);
Route::get('/scraper-prosple-db', [ScraperController::class, 'prospleStoreDb']);
Route::get('/scraper-glints', [ScraperController::class, 'glints']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/source-scraping', SourceScrapingLivewire::class)->name('source-scraping');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
