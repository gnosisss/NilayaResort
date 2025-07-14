<?php

namespace App\Filament\EmployeeResources;

use App\Filament\EmployeeResources\CheckoutTransactionDetailResource\Pages;
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
                Forms\Components\Textarea::make('notes')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction.transaction_code')
                    ->label('Transaction')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rentalUnit.address')
                    ->label('Rental Unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('checklist.item')
                    ->label('Checklist Item')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nights')
                    ->label('Number of Nights')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->relationship('transaction', 'transaction_code')
                    ->searchable()
                    ->label('Transaction'),
                Tables\Filters\SelectFilter::make('unit_id')
                    ->relationship('rentalUnit', 'address')
                    ->searchable()
                    ->label('Rental Unit'),
                Tables\Filters\Filter::make('nights')
                    ->form([
                        Forms\Components\TextInput::make('min_nights')
                            ->numeric()
                            ->label('Minimum Nights'),
                        Forms\Components\TextInput::make('max_nights')
                            ->numeric()
                            ->label('Maximum Nights'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_nights'],
                                fn (Builder $query, $min): Builder => $query->where('nights', '>=', $min),
                            )
                            ->when(
                                $data['max_nights'],
                                fn (Builder $query, $max): Builder => $query->where('nights', '<=', $max),
                            );
                    }),
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