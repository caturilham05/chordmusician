<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\Playlist;

class HomeController extends Controller
{
    public function index()
    {
        $home = Home::getHome();
        $playlists = Playlist::getLatestPlaylists(5);
        return view('index', [
            'home' => $home,
            'playlists' => $playlists,
            'title'  => 'Home'
        ]);
    }
}
