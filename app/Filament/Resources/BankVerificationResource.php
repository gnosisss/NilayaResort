<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankVerificationResource\Pages;
use App\Models\BankVerification;
use App\Models\User;
use App\Policies\BankVerificationPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BankVerificationResource extends Resource
{
    protected static ?string $model = BankVerification::class;
    
    protected static ?string $modelLabel = 'Bank Verification';
    
    protected static ?string $pluralModelLabel = 'Bank Verifications';

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    
    protected static ?string $navigationLabel = 'Bank Verifications';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 20;
    
    protected static ?string $recordTitleAttribute = 'verification_id';
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('documents_verified', false)
            ->orWhere('credit_approved', false)
            ->count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('documents_verified', false)
            ->orWhere('credit_approved', false)
            ->count() > 0
                ? 'warning'
                : 'success';
    }
    
    public static function canAccess(): bool
    {
        return Auth::user()->isBankOfficer();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('purchase_id')
                    ->relationship('propertyPurchase', 'purchase_code')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('bank_user_id')
                    ->relationship('bankUser', 'name')
                    ->required()
                    ->default(Auth::id())
                    ->disabled(fn (BankVerification $record = null) => $record === null)
                    ->searchable(),
                Forms\Components\Toggle::make('documents_verified')
                    ->required()
                    ->default(false),
                Forms\Components\Toggle::make('credit_approved')
                    ->required()
                    ->default(false),
                Forms\Components\TextInput::make('credit_score')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.1),
                Forms\Components\TextInput::make('approved_amount')
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Textarea::make('verification_notes')
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('propertyPurchase.purchase_code')
                    ->searchable()
                    ->sortable()
                    ->label('Purchase Code'),
                Tables\Columns\TextColumn::make('propertyPurchase.user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('bankUser.name')
                    ->searchable()
                    ->sortable()
                    ->label('Bank Officer'),
                Tables\Columns\IconColumn::make('documents_verified')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('credit_approved')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('credit_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approved_amount')
                    ->money('IDR')
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
                Tables\Filters\Filter::make('documents_verified')
                    ->query(fn (Builder $query): Builder => $query->where('documents_verified', true)),
                Tables\Filters\Filter::make('credit_approved')
                    ->query(fn (Builder $query): Builder => $query->where('credit_approved', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBankVerifications::route('/'),
            'create' => Pages\CreateBankVerification::route('/create'),
            'edit' => Pages\EditBankVerification::route('/{record}/edit'),
            'view' => Pages\ViewBankVerification::route('/{record}'),
        ];
    }
}