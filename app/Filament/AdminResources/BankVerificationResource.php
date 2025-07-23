<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\BankVerificationResource\Pages;
use App\Models\BankVerification;
use App\Models\PropertyPurchase;
use App\Models\User;
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
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class BankVerificationResource extends Resource
{
    protected static ?string $model = BankVerification::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('purchase_id')
                    ->label('Property Purchase')
                    ->options(PropertyPurchase::all()->pluck('purchase_code', 'purchase_id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                Select::make('bank_user_id')
                    ->label('Bank Officer')
                    ->options(User::where('role', 'bank')->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                Toggle::make('documents_verified')
                    ->label('Documents Verified')
                    ->default(false),
                    
                Toggle::make('credit_approved')
                    ->label('Credit Approved')
                    ->default(false),
                    
                TextInput::make('credit_score')
                    ->label('Credit Score')
                    ->numeric()
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(100),
                    
                TextInput::make('approved_amount')
                    ->label('Approved Amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->step(0.01),
                    
                Textarea::make('verification_notes')
                    ->label('Verification Notes')
                    ->maxLength(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('verification_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('propertyPurchase.purchase_code')
                    ->searchable()
                    ->sortable()
                    ->label('Purchase Code'),
                    
                TextColumn::make('propertyPurchase.rentalUnit.name')
                    ->searchable()
                    ->sortable()
                    ->label('Property'),
                    
                TextColumn::make('bankUser.name')
                    ->searchable()
                    ->sortable()
                    ->label('Bank Officer'),
                    
                IconColumn::make('documents_verified')
                    ->boolean()
                    ->label('Docs Verified'),
                    
                IconColumn::make('credit_approved')
                    ->boolean()
                    ->label('Credit Approved'),
                    
                TextColumn::make('credit_score')
                    ->sortable()
                    ->label('Credit Score'),
                    
                TextColumn::make('approved_amount')
                    ->money('IDR')
                    ->sortable()
                    ->label('Approved Amount'),
                    
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBankVerifications::route('/'),
            'create' => Pages\CreateBankVerification::route('/create'),
            'edit' => Pages\EditBankVerification::route('/{record}/edit'),
        ];
    }
}