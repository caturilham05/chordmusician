<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ChordController extends Controller
{
    // public function index($year, $month, $slug)
    // {
    //     $playlist = Playlist::getPlaylistBySlug($slug);
    //     if (!$playlist) {
    //         abort(404);
    //     }
    //     $sessionKey = 'clicked_playlist_' . $playlist->id;

    //     if (!session()->has($sessionKey)) {
    //         $playlist->increment('click');
    //         session([$sessionKey => true]);
    //     }

    //     $playlistsByBand = Playlist::getPlaylistsByBand($slug);
    //     $chord = Playlist::getPlaylistBySlug($slug);

    //     preg_match('/(?:embed\/|watch\?v=)([A-Za-z0-9_-]{11})/', $chord->link_youtube, $matches);
    //     $youtubeId = $matches[1] ?? null;

    //     return view('chord', [
    //         'youtubeId' => $youtubeId,
    //         'chord' => $chord,
    //         'playlistsByBand' => $playlistsByBand,
    //         'keywords' => sprintf('chord gitar %s %s, lirik lagu %s %s, original chord %s %s, chord dasar %s %s', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : ''),
    //         'SEOData' => new SEOData(
    //             title: sprintf('Chord %s - %s Original Chord', $chord ? $chord->band : 'Tidak Ditemukan', $chord ? $chord->title : ''),
    //             description: ($chord ? $chord->title : 'tidak ditemukan'),
    //             // description: 'Temukan chord gitar untuk lagu ' . ($chord ? $chord->title : 'tidak ditemukan') . ' di Chord Musisi.',
    //             // keywords: sprintf('chord gitar %s %s, lirik lagu %s %s, original chord %s %s, chord dasar %s %s', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : ''),
    //         ),
    //     ]);

    //     // return view('chord', [
    //     //     'title' => $playlist->slug . ' Chord Gitar dan Lirik Lagu - Chord Musician',
    //     //     'chord' => $chord,
    //     //     'playlistsByBand' => $playlistsByBand,
    //     //     'description' => 'Temukan chord gitar untuk lagu ' . ($chord ? $chord->title : 'tidak ditemukan') . ' di Chord Musisi.',
    //     //     'keywords' => sprintf('chord gitar %s %s, lirik lagu %s %s, original chord %s %s, chord dasar %s %s', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : ''),
    //     // ]);
    // }

    public function index($year, $month, $slug)
    {
        $playlist = Playlist::getPlaylistBySlug($slug);
        if (!$playlist) abort(404);

        $sessionKey = 'clicked_playlist_' . $playlist->id;
        if (!session()->has($sessionKey)) {
            $playlist->increment('click');
            session([$sessionKey => true]);
        }

        $playlistsByBand = Playlist::getPlaylistsByBand($slug);
        $chord = Playlist::getPlaylistBySlug($slug);

        preg_match('/(?:embed\/|watch\?v=)([A-Za-z0-9_-]{11})/', $chord->link_youtube, $matches);
        $youtubeId = $matches[1] ?? null;

        return view('chord', [
            'youtubeId' => $youtubeId,
            'chord' => $chord,
            'playlistsByBand' => $playlistsByBand,
            'keywords' => sprintf('chord gitar %s %s, lirik lagu %s %s, original chord %s %s, chord dasar %s %s', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : '', $chord ? $chord->title : '', $chord ? $chord->band : ''),
            'SEOData' => new SEOData(
                title: sprintf('Chord %s - %s Original Chord', $chord?->band ?? '', $chord?->title ?? ''),
                description: $chord?->title.' '.$chord->content ?? '',
                image: $youtubeId
                    ? "https://img.youtube.com/vi/$youtubeId/hqdefault.jpg"
                    : asset('favicon.png'),
            ),
        ]);
    }
}
