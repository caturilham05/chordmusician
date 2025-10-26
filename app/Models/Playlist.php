<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';
    protected $fillable = ['band', 'title', 'slug', 'content', 'published_at', 'link_youtube'];
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function getPlaylists()
    {
        return self::whereNotNull('published_at')
                    ->orderBy('published_at', 'desc')
                    ->paginate(3);
                    // ->get();
    }

    public static function getPlaylistBySlug($slug)
    {
        return self::where('slug', $slug)
                    ->whereNotNull('published_at')
                    ->first();
    }

    public static function getLatestPlaylists($limit = 5)
    {
        return self::whereNotNull('published_at')
                    ->orderBy('published_at', 'desc')
                    ->limit($limit)
                    ->get();
    }

    public static function searchPlaylists($query)
    {
        return self::where('title', 'like', '%' . $query . '%')
                    ->orWhere('band', 'like', '%' . $query . '%')
                    ->whereNotNull('published_at')
                    ->orderBy('published_at', 'desc')
                    ->paginate(2)
                    ->withQueryString();
    }

    public function getPublishedFormattedDateAttribute()
    {
        return $this->published_at
        ? $this->published_at->translatedFormat('d F Y')
        : 'Belum Dipublikasikan';
    }
}
