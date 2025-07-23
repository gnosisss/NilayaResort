<?php

namespace App\Filament\AdminWidgets;

use App\Models\Booking;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?int $sort = 7;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Latest Bookings';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('booking_code')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                    
                TextColumn::make('unit.name')
                    ->label('Rental Unit')
                    ->searchable(),
                    
                TextColumn::make('check_in_date')
                    ->date()
                    ->sortable(),
                    
                TextColumn::make('check_out_date')
                    ->date()
                    ->sortable(),
                    
                TextColumn::make('total_price')
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn (Booking $record): string => route('filament.admin.resources.bookings.view', $record))
                    ->icon('heroicon-m-eye'),
            ])
            ->paginated(false);
    }
}