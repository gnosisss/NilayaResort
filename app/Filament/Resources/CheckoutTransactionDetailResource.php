<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckoutTransactionDetailResource\Pages;
use App\Models\CheckoutTransactionDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CheckoutTransactionDetailResource extends Resource
{
    protected static ?string $model = CheckoutTransactionDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Transaction Details';
    
    protected static ?string $navigationGroup = 'Financial Management';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transaction_id')
                    ->relationship('transaction', 'transaction_code')
                    ->required(),
                Forms\Components\Select::make('unit_id')
                    ->relationship('rentalUnit', 'address')
                    ->required(),
                Forms\Components\Select::make('checklist_id')
                    ->relationship('checklist', 'item')
                    ->nullable(),
                Forms\Components\TextInput::make('nights')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('price_per_night')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction.transaction_code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rentalUnit.address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('checklist.item')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nights')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
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
                Tables\Filters\SelectFilter::make('transaction_id')
                    ->relationship('transaction', 'transaction_code'),
                Tables\Filters\SelectFilter::make('unit_id')
                    ->relationship('rentalUnit', 'address'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCheckoutTransactionDetails::route('/'),
            'create' => Pages\CreateCheckoutTransactionDetail::route('/create'),
            'edit' => Pages\EditCheckoutTransactionDetail::route('/{record}/edit'),
        ];
    }
}