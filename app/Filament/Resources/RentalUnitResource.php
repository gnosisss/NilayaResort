<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalUnitResource\Pages;
use App\Filament\Resources\RentalUnitResource\RelationManagers;
use App\Models\RentalUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RentalUnitResource extends Resource
{
    protected static ?string $model = RentalUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                        $set('slug', str($state)->slug());
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price_per_night')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_for_sale')
                    ->label('Available for Sale')
                    ->helperText('Enable this if the property is available for purchase')
                    ->default(false)
                    ->live(),
                Forms\Components\TextInput::make('sale_price')
                    ->label('Property Price')
                    ->helperText('The selling price of the property, not the rental price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(fn (Forms\Get $get): bool => $get('is_for_sale'))
                    ->hidden(fn (Forms\Get $get): bool => !$get('is_for_sale'))
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_for_sale')
                    ->boolean()
                    ->label('For Sale')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('Property Price')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalUnits::route('/'),
            'create' => Pages\CreateRentalUnit::route('/create'),
            'edit' => Pages\EditRentalUnit::route('/{record}/edit'),
        ];
    }
}
