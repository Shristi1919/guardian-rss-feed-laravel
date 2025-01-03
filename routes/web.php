<?php

use App\Http\Controllers\RssFeedController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rssfeed/{section}', [RssFeedController::class, 'getRssFeed']);
