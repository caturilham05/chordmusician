<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/playlist', [App\Http\Controllers\PlaylistController::class, 'index'])->name('playlist');
Route::get('/playlist', [App\Http\Controllers\PlaylistController::class, 'index'])->name('playlist');
Route::get('/request-chord', [App\Http\Controllers\RequestRecordController::class, 'index'])->name('request_chord');
Route::get('{year}/{month}/{slug}', [App\Http\Controllers\ChordController::class, 'index'])->where([
    'year' => '[0-9]{4}',
    'month' => '[0-9]{2}',
    'slug' => '[A-Za-z0-9\-]+'
])->name('chord');
Route::get('/search', [App\Http\Controllers\PlaylistController::class, 'search'])->name('playlist_search');
