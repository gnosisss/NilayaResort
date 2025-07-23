<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\ImageResource\Pages;
use App\Models\Image;
use App\Models\RentalUnit;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('unit_id')
                    ->label('Rental Unit')
                    ->options(RentalUnit::all()->pluck('name', 'unit_id'))
                    ->required()
                    ->searchable(),
                    
                FileUpload::make('image')
                    ->required()
                    ->image()
                    ->directory('rental-units')
                    ->visibility('public'),
                    
                TextInput::make('title')
                    ->maxLength(255),
                    
                Textarea::make('description')
                    ->maxLength(1000),
                    
                Toggle::make('is_featured')
                    ->label('Featured Image')
                    ->default(false),
                    
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image_id')
                    ->sortable()
                    ->label('ID'),
                    
                ImageColumn::make('image')
                    ->square(),
                    
                TextColumn::make('rentalUnit.name')
                    ->searchable()
                    ->sortable()
                    ->label('Rental Unit'),
                    
                TextColumn::make('title')
                    ->searchable(),
                    
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                    
                TextColumn::make('sort_order')
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
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}