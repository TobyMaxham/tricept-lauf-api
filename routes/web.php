<?php

use App\Http\Controllers\AppAuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [RankingController::class, 'index'])->name('ranking');
    Route::get('/tour-images', [ImageController::class, 'index'])->name('images');
    Route::get('/results', [RankingController::class, 'results'])->name('results');
    Route::get('/graphs', [ChartController::class, 'index'])->name('graphs');
});

Route::get('/logout', [AppAuthController::class, 'getLogout'])->name('logout');
Route::get('/login', [AppAuthController::class, 'getLogin'])->name('login');
Route::post('/login', [AppAuthController::class, 'postLogin']);
