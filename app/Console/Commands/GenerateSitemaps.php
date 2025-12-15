<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Playlist;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class GenerateSitemaps extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap index and child sitemaps';

    const CHUNK_SIZE = 50;

    public function handle()
    {
        $publicPath = dirname(base_path()) . '/public_html';

        // =========================
        // 1. Sitemap STATIC
        // =========================
        $staticSitemap = Sitemap::create();

        $staticSitemap->add(
            Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency('daily')
        );

        $staticSitemap->add(
            Url::create('/playlist')
                ->setPriority(0.9)
                ->setChangeFrequency('daily')
        );

        $staticSitemap->add(
            Url::create('/request-chord')
                ->setPriority(0.7)
                ->setChangeFrequency('weekly')
        );

        $staticSitemap->writeToFile($publicPath . '/sitemap-static.xml');

        // =========================
        // 2. Sitemap PLAYLIST (chunked)
        // =========================
        $playlistFiles = [];

        Playlist::whereNotNull('published_at')
            ->orderBy('published_at')
            ->chunk(self::CHUNK_SIZE, function ($playlists, $index) use (&$playlistFiles, $publicPath) {

                $sitemap = Sitemap::create();
                $fileNumber = count($playlistFiles) + 1;
                $fileName = "sitemap-playlist-{$fileNumber}.xml";

                foreach ($playlists as $playlist) {
                    $sitemap->add(
                        Url::create(url("/{$playlist->published_at->format('Y/m')}/{$playlist->slug}"))
                            ->setLastModificationDate($playlist->updated_at)
                            ->setChangeFrequency('weekly')
                            ->setPriority(0.8)
                    );
                }

                $sitemap->writeToFile($publicPath . '/' . $fileName);
                $playlistFiles[] = $fileName;
            });

        // =========================
        // 3. Sitemap INDEX
        // =========================
        $indexSitemap = Sitemap::create();

        $indexSitemap->add(url('/sitemap-static.xml'));

        foreach ($playlistFiles as $file) {
            $indexSitemap->add(url("/{$file}"));
        }

        $indexSitemap->writeToFile($publicPath . '/sitemap.xml');

        // =========================
        // 4. Ping Google
        // =========================
        Http::get('https://www.google.com/ping', [
            'sitemap' => url('/sitemap.xml')
        ]);

        $this->info('✅ Sitemap index & child sitemaps generated successfully');
    }
}
