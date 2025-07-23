<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\RentalUnitResource\Pages;
use App\Filament\AdminResources\RentalUnitResource\RelationManagers;
use App\Models\RentalUnit;
use App\Models\Category;
use App\Models\User;
use App\Models\Facility;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RentalUnitResource extends Resource
{
    protected static ?string $model = RentalUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Owner')
                    ->options(User::where('role', 'employee')->orWhere('role', 'admin')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                    
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'category_id'))
                    ->required()
                    ->searchable(),
                    
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
                    
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(RentalUnit::class, 'slug', ignoreRecord: true),
                    
                Textarea::make('address')
                    ->required()
                    ->maxLength(1000),
                    
                TextInput::make('type')
                    ->maxLength(255),
                    
                TextInput::make('price_per_night')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                    
                Toggle::make('is_for_sale')
                    ->label('For Sale')
                    ->default(false),
                    
                TextInput::make('sale_price')
                    ->numeric()
                    ->prefix('Rp')
                    ->visible(fn (callable $get) => $get('is_for_sale')),
                    
                CheckboxList::make('facilities')
                    ->relationship('facilities', 'facility_name')
                    ->options(Facility::all()->pluck('facility_name', 'facility_id'))
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Category'),
                    
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Owner'),
                    
                TextColumn::make('price_per_night')
                    ->money('IDR')
                    ->sortable(),
                    
                IconColumn::make('is_for_sale')
                    ->boolean()
                    ->label('For Sale'),
                    
                TextColumn::make('sale_price')
                    ->money('IDR')
                    ->sortable(),
                    
                    
                TextColumn::make('facilities_count')
                    ->counts('facilities')
                    ->label('Facilities'),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
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
            RelationManagers\ImagesRelationManager::class,
            RelationManagers\AvailabilitiesRelationManager::class,
            RelationManagers\FacilitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalUnits::route('/'),
            'create' => Pages\CreateRentalUnit::route('/create'),
            'view' => Pages\ViewRentalUnit::route('/{record}'),
            'edit' => Pages\EditRentalUnit::route('/{record}/edit'),
        ];
    }
}