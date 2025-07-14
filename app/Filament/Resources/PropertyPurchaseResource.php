<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyPurchaseResource\Pages;
use App\Models\PropertyPurchase;
use App\Policies\PropertyPurchasePolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PropertyPurchaseResource extends Resource
{
    protected static ?string $model = PropertyPurchase::class;
    
    protected static ?string $modelLabel = 'Property Purchase';
    
    protected static ?string $pluralModelLabel = 'Property Purchases';

    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?string $navigationLabel = 'Property Purchases';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 10;
    
    protected static ?string $recordTitleAttribute = 'purchase_code';
    
    public static function getNavigationBadge(): ?string
    {
        if (Auth::user()->hasRole('bank_officer')) {
            return static::getModel()::where('status', 'pending')
                ->count();
        }
        
        return null;
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        if (Auth::user()->hasRole('bank_officer')) {
            return static::getModel()::where('status', 'pending')
                ->count() > 0
                    ? 'warning'
                    : 'success';
        }
        
        return null;
    }
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->default(fn () => Auth::user()->isBankOfficer() ? null : Auth::id())
                    ->disabled(fn () => !Auth::user()->isBankOfficer() && Auth::check())
                    ->searchable(),
                Forms\Components\Select::make('unit_id')
                    ->relationship('rentalUnit', 'address')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('purchase_code')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->default(fn () => 'PP-' . strtoupper(substr(md5(time()), 0, 8)))
                    ->disabled(fn (?PropertyPurchase $record = null) => $record?->exists ?? false),
                Forms\Components\TextInput::make('purchase_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'documents_verified' => 'Documents Verified',
                        'credit_approved' => 'Credit Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])
                    ->required()
                    ->default('pending')
                    ->disabled(fn () => !Auth::user()->isBankOfficer()),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('purchase_code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('rentalUnit.address')
                    ->searchable()
                    ->sortable()
                    ->label('Property'),
                Tables\Columns\TextColumn::make('purchase_amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => 
                        match ($state) {
                            'rejected' => 'danger',
                            'pending' => 'warning',
                            'completed' => 'success',
                            'documents_verified' => 'info',
                            'credit_approved' => 'info',
                            default => 'secondary',
                        }
                    )
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'documents_verified' => 'Documents Verified',
                        'credit_approved' => 'Credit Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (PropertyPurchase $record) => 
                        Auth::user()->isBankOfficer() || 
                        (Auth::id() === $record->user_id && $record->status === 'pending')
                    ),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (PropertyPurchase $record) => 
                        Auth::user()->isBankOfficer() || 
                        (Auth::id() === $record->user_id && $record->status === 'pending')
                    ),
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
            'index' => Pages\ListPropertyPurchases::route('/'),
            'create' => Pages\CreatePropertyPurchase::route('/create'),
            'edit' => Pages\EditPropertyPurchase::route('/{record}/edit'),
            'view' => Pages\ViewPropertyPurchase::route('/{record}'),
        ];
    }
}