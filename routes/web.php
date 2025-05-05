<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard_utama');
});


Route::get('/komponen', function () {
    return view('komponen');
});

Route::get('/proses-mekanik', function () {
    return view('proses_mekanik');
});

Route::get('/detail-proses', function () {
    return view('detail_komponen');
});