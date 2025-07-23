<?php

namespace App\Filament\AdminWidgets;

use App\Models\RentalUnit;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UnitAvailabilityWidget extends BaseWidget
{
    protected static ?int $sort = 9;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Rental Unit Availability';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(RentalUnit::query())
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('price_per_night')
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                    
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'occupied' => 'warning',
                        'maintenance' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                    
                TextColumn::make('current_booking')
                    ->label('Current/Next Booking')
                    ->getStateUsing(function (RentalUnit $record) {
                        $currentBooking = $record->bookings()
                            ->where('status', 'confirmed')
                            ->where(function ($query) {
                                $query->where('check_in_date', '<=', now())
                                    ->where('check_out_date', '>=', now());
                            })
                            ->first();
                            
                        if ($currentBooking) {
                            return 'Currently booked until ' . $currentBooking->check_out_date->format('M d, Y');
                        }
                        
                        $nextBooking = $record->bookings()
                            ->where('status', 'confirmed')
                            ->where('check_in_date', '>', now())
                            ->orderBy('check_in_date')
                            ->first();
                            
                        if ($nextBooking) {
                            return 'Next booking on ' . $nextBooking->check_in_date->format('M d, Y');
                        }
                        
                        return 'No upcoming bookings';
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'occupied' => 'Occupied',
                        'maintenance' => 'Maintenance',
                    ]),
                    
                SelectFilter::make('category_id')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn (RentalUnit $record): string => route('filament.admin.resources.rental-units.view', $record))
                    ->icon('heroicon-m-eye'),
            ])
            ->defaultSort('status', 'asc');
    }
}