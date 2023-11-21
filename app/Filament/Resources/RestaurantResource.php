<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantResource\Pages;
use App\Filament\Resources\RestaurantResource\RelationManagers;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Restaurant';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Restaurant Logo')
                        ->image()
                        ->disk('public'),
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\Fieldset::make('Contact')->schema([
                        Forms\Components\TextInput::make('phone')
                            ->type('tel')
                            ->required(),
                        Forms\Components\TextInput::make('email'),
                    ]),
                    Forms\Components\Textarea::make('address')
                        ->required(),
                    Forms\Components\Select::make('user_id')
                        ->required()
                        ->label('Owner')
                        ->relationship('user', 'name')
                        ->searchable(),
                    Forms\Components\Textarea::make('description'),
                    Forms\Components\Toggle::make('active')
                        ->label('Activate this restaurant')
                        ->hint("When disabled, this restaurant won't be visible in the app."),
                    Forms\Components\Select::make('category_id')
                        ->required()
                    ->label("Category")
                    ->searchable()
                    ->preload()
                    ->relationship('category', 'name'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('menus_count')
                    ->counts('menus')
                    ->label('Menus'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MenusRelationManager::class,
            RelationManagers\MenuGroupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
            'view' => Pages\ViewRestaurant::route('/{record}'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()->schema([
                    ImageEntry::make('image')->columnSpanFull(),
                    TextEntry::make('id'),
                    TextEntry::make('name'),
                    TextEntry::make('user.name')
                        ->label('Owner Name'),
                    IconEntry::make('active')->boolean()->label("Active?"),
                    TextEntry::make('address'),
                    TextEntry::make('phone'),
                    TextEntry::make('email'),
                    TextEntry::make('created_at')
                        ->date(),
                    TextEntry::make('category.name')
                        ->badge()
                        ->label('Category')
                ])->columns(2),

                Section::make()
                    ->schema([
                    TextEntry::make('description')
                ])
            ]);
    }
}
