<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;

class ChordController extends Controller
{
    public function index($year, $month, $slug)
    {
        $playlist = Playlist::getPlaylistBySlug($slug);
        $sessionKey = 'clicked_playlist_' . $playlist->id;

        if (!session()->has($sessionKey)) {
            $playlist->increment('click');
            session([$sessionKey => true]);
        }

        $playlistsByBand = Playlist::getPlaylistsByBand($slug);
        $chord = Playlist::getPlaylistBySlug($slug);
        return view('chord', [
            'title' => 'Chord',
            'chord' => $chord,
            'playlistsByBand' => $playlistsByBand,
            'description' => 'Temukan chord gitar untuk lagu ' . ($chord ? $chord->title : 'tidak ditemukan') . ' di Chord Musisi.'
        ]);
    }
}
