<?php

namespace App\Filament\Resources\RestaurantResource\Widgets;

use App\Models\Restaurant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class RestoStat extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    public ?Model $record = null;
    protected function getStats(): array
    {
        return [
            Stat::make('Available Menus', $this->record->menus()->available()->count()),
            Stat::make('Today\'s Orders', rand(1, 30)),
        ];
    }
}
