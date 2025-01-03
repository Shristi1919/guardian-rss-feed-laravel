<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RssFeedController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('rssfeed/{section}', [RssFeedController::class, 'getRssFeed'])
    ->where('section', '[a-z-]+');
