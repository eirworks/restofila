<?php

namespace App\Filament\Resources\RestaurantResource\RelationManagers;

use App\Models\Menu;
use App\Models\MenuGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class MenusRelationManager extends RelationManager
{
    protected static string $relationship = 'menus';

    protected static ?string $title = "Restaurant's Menus";

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->type('number')
                    ->required()
                    ->default(1)
                    ->minValue(1),
                Forms\Components\TextInput::make('discount')
                    ->type('number')
                    ->default(0)
                    ->minValue(0),
                Forms\Components\Toggle::make('available'),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
                Forms\Components\Select::make('menu_group_id')
                    ->searchable()
                    ->preload()
                    ->relationship('menuGroup', 'name', function (Builder $query) {
                        $query->where('restaurant_id', $this->getOwnerRecord()->id);
                    })
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('menuGroup.name')
                    ->badge()
                    ->label('Group'),
                Tables\Columns\TextColumn::make('price')
                    ->money('usd'),
                Tables\Columns\TextColumn::make('discount')
                    ->money('usd')
                ,
                Tables\Columns\IconColumn::make('available')->boolean(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\Filter::make('available')
                    ->query(fn (Builder $query): Builder => $query->where('available', true)),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('toggle-available')
                    ->label(fn (Menu $record) => $record->available ? 'Set Unavailable' : 'Set Available')
                    ->icon(fn (Menu $record) => $record->available ? 'heroicon-s-x-mark' : 'heroicon-s-check')
                    ->color(fn(Menu $record) => $record->available ? 'danger' : 'success')
                    ->action(fn (Menu $record) => $record->update(['available' => ! $record->available])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggle-available')
                        ->label('Toggle Available')
                        ->icon('heroicon-s-check')
                        ->action(fn(Collection $records) => $records->each->update(['available' => ! $records->first()->available])),
                ]),
            ]);
    }
}
