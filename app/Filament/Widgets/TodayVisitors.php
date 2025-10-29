<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Playlist;

class TodayVisitors extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $todayVisitors = Playlist::sum('click');
        $yesterdayVisitors = Playlist::sum('click_yesterday');

        return [
            Stat::make('Pengunjung Hari Ini', number_format($todayVisitors))
                ->description('Total pengunjung hari ini')
                ->icon('heroicon-o-user-group')
                ->color('success'),
            Stat::make('Pengunjung Kemarin', number_format($yesterdayVisitors))
                ->description('Total pengunjung kemarin')
                ->icon('heroicon-o-user-group')
                ->color('primary'),
        ];
    }
}
