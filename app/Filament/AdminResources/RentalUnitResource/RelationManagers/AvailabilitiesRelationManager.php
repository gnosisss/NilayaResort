<?php

namespace App\Filament\AdminResources\RentalUnitResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class AvailabilitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'availabilities';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_date')
            ->columns([
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
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}