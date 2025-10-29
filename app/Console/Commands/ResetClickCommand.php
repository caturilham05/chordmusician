<?php
// menit jam hari-bulan minggu
// 00 00 * * * cd /home/chor5665/chordmusician && /usr/local/bin/php artisan schedule:run >> /home/chor5665/chordmusician/storage/logs/cron.log 2>&1


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Playlist;

class ResetClickCommand extends Command
{
    protected $signature = 'click:reset';
    protected $description = 'Reset semua klik menjadi 0 setiap tengah malam';

    public function handle()
    {
        $p = Playlist::select('id', 'click', 'click_yesterday')->get();
        foreach ($p as $playlist) {
            $playlist->click_yesterday = $playlist->click;
            $playlist->click = 0;
            $playlist->save();
        }
        $this->info('Semua klik berhasil direset.');
    }
}

