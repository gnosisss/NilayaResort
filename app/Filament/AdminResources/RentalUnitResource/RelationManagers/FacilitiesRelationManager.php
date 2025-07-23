<?php

namespace App\Filament\AdminResources\RentalUnitResource\RelationManagers;

use App\Models\Facility;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FacilitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'facilities';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('facility_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('facility_name')
            ->columns([
                TextColumn::make('facility_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('facility_name')
                    ->searchable()
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
                AttachAction::make()
                    ->recordSelectSearchColumns(['facility_name'])
                    ->preloadRecordSelect(),
            ])
            ->actions([
                DetachAction::make(),
            ])
            ->bulkActions([
                DetachBulkAction::make(),
            ]);
    }
}