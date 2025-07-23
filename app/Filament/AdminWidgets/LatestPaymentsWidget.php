<?php

namespace App\Filament\AdminWidgets;

use App\Models\PaymentTransaction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPaymentsWidget extends BaseWidget
{
    protected static ?int $sort = 8;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Latest Payments';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PaymentTransaction::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('payment_code')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                    
                TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('payment_method')
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->sortable(),
                    
                TextColumn::make('payment_date')
                    ->date()
                    ->sortable(),
                    
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn (PaymentTransaction $record): string => route('filament.admin.resources.payment-transactions.view', $record))
                    ->icon('heroicon-m-eye'),
            ])
            ->paginated(false);
    }
}