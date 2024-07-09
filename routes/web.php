<?php

use App\Http\Controllers\WebScrapingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/parse', [WebScrapingController::class, 'parseHtml']);
Route::get('/parse/txt', [WebScrapingController::class, 'parseTxt']);
Route::get('/scrape-and-save-clean-html', [App\Http\Controllers\WebScrapingController::class, 'scrapeAndSaveCleanHtml']);

