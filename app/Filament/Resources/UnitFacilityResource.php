<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitFacilityResource\Pages;
use App\Models\UnitFacility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UnitFacilityResource extends Resource
{
    protected static ?string $model = UnitFacility::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    
    protected static ?string $navigationLabel = 'Unit Facilities';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('unit_id')
                    ->relationship('rentalUnit', 'type')
                    ->required(),
                Forms\Components\Select::make('facility_id')
                    ->relationship('facility', 'facility_name')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rentalUnit.address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('facility.facility_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
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
                Tables\Filters\SelectFilter::make('unit_id')
                    ->relationship('rentalUnit', 'address'),
                Tables\Filters\SelectFilter::make('facility_id')
                    ->relationship('facility', 'facility_name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUnitFacilities::route('/'),
            'create' => Pages\CreateUnitFacility::route('/create'),
            'edit' => Pages\EditUnitFacility::route('/{record}/edit'),
        ];
    }
}