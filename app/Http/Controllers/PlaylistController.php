<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Home;


class PlaylistController extends Controller
{
    public function index()
    {
        $home = Home::getHome();
        $playlists = Playlist::getPlaylists();
        return view('playlist', [
            'home' => $home,
            'playlists' => $playlists,
            'title' => 'Kumpulan Chord Gitar dan Lirik Lagu - Chord Musician'
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->route('playlist');
        }

        $playlists = Playlist::searchPlaylists($query);
        $home = Home::getHome();
        return view('search_results', [
            'home' => $home,
            'playlists' => $playlists,
            'query' => $query,
            'title' => 'Hasil Pencarian untuk "' . $query . '" - Chord Musician'
        ]);
    }
}
