<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\UnitFacilityResource\Pages;
use App\Models\UnitFacility;
use App\Models\RentalUnit;
use App\Models\Facility;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitFacilityResource extends Resource
{
    protected static ?string $model = UnitFacility::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 6;
    
    protected static ?string $pluralModelLabel = 'Unit Facilities';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('unit_id')
                    ->label('Rental Unit')
                    ->options(RentalUnit::all()->pluck('name', 'unit_id'))
                    ->required()
                    ->searchable(),
                    
                Select::make('facility_id')
                    ->label('Facility')
                    ->options(Facility::all()->pluck('facility_name', 'facility_id'))
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit_facility_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('rentalUnit.name')
                    ->searchable()
                    ->sortable()
                    ->label('Rental Unit'),
                    
                TextColumn::make('facility.facility_name')
                    ->searchable()
                    ->sortable()
                    ->label('Facility'),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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