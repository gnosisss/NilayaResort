<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\PropertyPurchaseResource\Pages;
use App\Filament\AdminResources\PropertyPurchaseResource\RelationManagers;
use App\Models\PropertyPurchase;
use App\Models\RentalUnit;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class PropertyPurchaseResource extends Resource
{
    protected static ?string $model = PropertyPurchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Buyer')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                Select::make('unit_id')
                    ->label('Property')
                    ->options(RentalUnit::where('is_for_sale', true)->pluck('name', 'unit_id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                TextInput::make('purchase_code')
                    ->label('Purchase Code')
                    ->default(fn () => PropertyPurchase::generatePurchaseCode())
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                    
                TextInput::make('purchase_amount')
                    ->label('Purchase Amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                    
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),
                    
                Textarea::make('notes')
                    ->label('Notes')
                    ->maxLength(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purchase_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('purchase_code')
                    ->searchable()
                    ->sortable()
                    ->label('Purchase Code'),
                    
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Buyer'),
                    
                TextColumn::make('rentalUnit.name')
                    ->searchable()
                    ->sortable()
                    ->label('Property'),
                    
                TextColumn::make('purchase_amount')
                    ->money('IDR')
                    ->sortable()
                    ->label('Amount'),
                    
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'verified',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
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
            RelationManagers\DocumentsRelationManager::class,
            RelationManagers\BankVerificationRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPropertyPurchases::route('/'),
            'create' => Pages\CreatePropertyPurchase::route('/create'),
            'view' => Pages\ViewPropertyPurchase::route('/{record}'),
            'edit' => Pages\EditPropertyPurchase::route('/{record}/edit'),
        ];
    }
}