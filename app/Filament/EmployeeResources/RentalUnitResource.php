<?php

namespace App\Filament\EmployeeResources;

use App\Filament\EmployeeResources\RentalUnitResource\Pages;
use App\Models\RentalUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RentalUnitResource extends Resource
{
    protected static ?string $model = RentalUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?string $navigationLabel = 'Rental Units';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'villa' => 'Villa',
                        'apartment' => 'Apartment',
                        'house' => 'House',
                        'cottage' => 'Cottage',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('bedrooms')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('bathrooms')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('size')
                    ->required()
                    ->numeric()
                    ->suffix('m²'),
                Forms\Components\TextInput::make('base_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'occupied' => 'Occupied',
                        'maintenance' => 'Under Maintenance',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->directory('rental-units')
                    ->maxSize(5120)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('amenities')
                    ->maxLength(500)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bedrooms')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bathrooms')
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'occupied' => 'warning',
                        'maintenance' => 'danger',
                        'inactive' => 'gray',
                        default => 'gray',
                    }),
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
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'villa' => 'Villa',
                        'apartment' => 'Apartment',
                        'house' => 'House',
                        'cottage' => 'Cottage',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'occupied' => 'Occupied',
                        'maintenance' => 'Under Maintenance',
                        'inactive' => 'Inactive',
                    ]),
                Tables\Filters\Filter::make('bedrooms')
                    ->form([
                        Forms\Components\TextInput::make('bedrooms')
                            ->numeric()
                            ->label('Number of Bedrooms'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['bedrooms'],
                            fn (Builder $query, $value): Builder => $query->where('bedrooms', $value)
                        );
                    }),
                Tables\Filters\Filter::make('bathrooms')
                    ->form([
                        Forms\Components\TextInput::make('bathrooms')
                            ->numeric()
                            ->label('Number of Bathrooms'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['bathrooms'],
                            fn (Builder $query, $value): Builder => $query->where('bathrooms', $value)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'view' => Pages\ViewRentalUnit::route('/{record}'),
        ];
    }
}