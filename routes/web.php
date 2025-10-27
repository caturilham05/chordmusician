<?php

use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Playlist;

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

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create();

    // Tambahkan halaman statis (misal homepage, about, contact)
    $sitemap->add(Url::create('/')->setPriority(1.0));
    $sitemap->add(Url::create('/playlist')->setPriority(0.5));
    $sitemap->add(Url::create('/request-chord')->setPriority(0.5));

    // Tambahkan halaman dinamis (misal daftar chord)
    foreach (Playlist::latest()->get() as $playlist) {
        $sitemap->add(
            Url::create(url("/{$playlist->published_at->format('Y/m')}/{$playlist->slug}"))
                ->setLastModificationDate($playlist->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        );
    }

    return $sitemap->toResponse(request());
});
