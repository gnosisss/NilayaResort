<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\AvailabilityResource\Pages;
use App\Models\Availability;
use App\Models\RentalUnit;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class AvailabilityResource extends Resource
{
    protected static ?string $model = Availability::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('unit_id')
                    ->label('Rental Unit')
                    ->options(RentalUnit::all()->pluck('name', 'unit_id'))
                    ->required()
                    ->searchable(),
                    
                DatePicker::make('start_date')
                    ->required(),
                    
                DatePicker::make('end_date')
                    ->required()
                    ->after('start_date'),
                    
                Toggle::make('is_available')
                    ->label('Available')
                    ->default(true),
                    
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'maintenance' => 'Maintenance',
                        'blocked' => 'Blocked',
                    ])
                    ->required()
                    ->default('available'),
                    
                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp')
                    ->hint('Leave empty to use default unit price'),
                    
                Textarea::make('notes')
                    ->maxLength(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('availability_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('rentalUnit.name')
                    ->searchable()
                    ->sortable()
                    ->label('Rental Unit'),
                    
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                    
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                    
                IconColumn::make('is_available')
                    ->boolean()
                    ->label('Available'),
                    
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'booked' => 'warning',
                        'maintenance' => 'danger',
                        'blocked' => 'gray',
                        default => 'gray',
                    }),
                    
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('created_at')
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
            'index' => Pages\ListAvailabilities::route('/'),
            'create' => Pages\CreateAvailability::route('/create'),
            'edit' => Pages\EditAvailability::route('/{record}/edit'),
        ];
    }
}