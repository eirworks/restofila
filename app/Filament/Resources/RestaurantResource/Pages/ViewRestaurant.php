<?php

namespace App\Filament\Resources\RestaurantResource\Pages;

use App\Filament\Resources\RestaurantResource;
use App\Filament\Resources\RestaurantResource\Widgets\RestoStat;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewRestaurant extends ViewRecord
{
    protected static string $resource = RestaurantResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->record->name;
    }

    public function getBreadcrumb(): string
    {
        return $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RestoStat::class
        ];
    }


}
