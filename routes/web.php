<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/admin/{any?}', function () {
    return view('admin');
})->where('any', '.*');
