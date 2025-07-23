<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\ChecklistResource\Pages;
use App\Models\Checklist;
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

class ChecklistResource extends Resource
{
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('item')
                    ->required()
                    ->maxLength(255),
                    
                Textarea::make('description')
                    ->maxLength(1000)
                    ->columnSpanFull(),
                    
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                    
                Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('checklist_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('item')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('description')
                    ->searchable()
                    ->limit(50),
                    
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                    
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Active'),
                    
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
            'index' => Pages\ListChecklists::route('/'),
            'create' => Pages\CreateChecklist::route('/create'),
            'edit' => Pages\EditChecklist::route('/{record}/edit'),
        ];
    }
}