<?php

namespace App\Filament\Widgets;

use App\Models\Restaurant;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Restaurants', Restaurant::where('active', true)->count()),
            Stat::make('Users', User::count()),
        ];
    }
}
