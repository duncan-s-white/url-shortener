<?php

use App\Http\Controllers\UrlShorteningController;
use Illuminate\Support\Facades\Route;

Route::post('/encode', [UrlShorteningController::class, 'store']);

Route::get('/decode', [UrlShorteningController::class, 'show']);
