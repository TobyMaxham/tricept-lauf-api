<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [RankingController::class, 'index'])->name('ranking');
Route::get('/images', [ImageController::class, 'index'])->name('images');

Route::get('/results', [RankingController::class, 'results'])->name('results');
