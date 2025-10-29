<?php

// 5 12 * * * cd /home/chor5665/chordmusician && php artisan schedule:run >> /dev/null 2>&1

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Playlist;

class ResetClickCommand extends Command
{
    protected $signature = 'click:reset';
    protected $description = 'Reset semua klik menjadi 0 setiap tengah malam';

    public function handle()
    {
        Playlist::query()->update(['click' => 0]);
        $this->info('Semua klik berhasil direset.');
    }
}

