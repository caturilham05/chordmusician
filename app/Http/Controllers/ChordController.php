<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;

class ChordController extends Controller
{
    public function index($year, $month, $slug)
    {
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
