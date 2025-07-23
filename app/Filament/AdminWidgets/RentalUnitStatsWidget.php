<?php

namespace App\Filament\AdminWidgets;

use App\Models\RentalUnit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class RentalUnitStatsWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected function getStats(): array
    {
        // Get total rental units count
        $totalUnits = RentalUnit::count();
        
        // Get units by availability status
        $availableUnits = RentalUnit::where('status', 'available')->count();
        $occupiedUnits = RentalUnit::where('status', 'occupied')->count();
        $maintenanceUnits = RentalUnit::where('status', 'maintenance')->count();
        
        // Get units by category
        $unitsByCategory = RentalUnit::select('category_id', DB::raw('count(*) as count'))
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->mapWithKeys(function ($item) {
                $categoryName = $item->category ? $item->category->name : 'Uncategorized';
                return [$categoryName => $item->count];
            })
            ->toArray();
            
        $categoriesText = '';
        foreach ($unitsByCategory as $category => $count) {
            $categoriesText .= "$category: $count\n";
        }
        
        // Get average price of units
        $averagePrice = RentalUnit::avg('price_per_night');
        
        return [
            Stat::make('Total Rental Units', $totalUnits)
                ->description('All rental units')
                ->descriptionIcon('heroicon-m-home')
                ->color('primary'),
                
            Stat::make('Unit Status', "Available: $availableUnits\nOccupied: $occupiedUnits\nMaintenance: $maintenanceUnits")
                ->description('Distribution by status')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
                
            Stat::make('Units by Category', $categoriesText)
                ->description('Distribution by category')
                ->descriptionIcon('heroicon-m-tag')
                ->color('success'),
                
            Stat::make('Average Price', 'Rp ' . number_format($averagePrice, 0, ',', '.'))
                ->description('Average price per night')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
        ];
    }
}