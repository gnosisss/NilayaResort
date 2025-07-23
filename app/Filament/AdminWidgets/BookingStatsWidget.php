<?php

namespace App\Filament\AdminWidgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class BookingStatsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected function getStats(): array
    {
        // Get total bookings count
        $totalBookings = Booking::count();
        
        // Get bookings by status
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        
        // Get total booking value
        $totalBookingValue = Booking::sum('total_price');
        
        // Get upcoming bookings (check-in date in the next 7 days)
        $upcomingBookings = Booking::where('check_in_date', '>=', now())
            ->where('check_in_date', '<=', now()->addDays(7))
            ->count();
        
        return [
            Stat::make('Total Bookings', $totalBookings)
                ->description('All bookings')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
                
            Stat::make('Booking Status', "Pending: $pendingBookings\nConfirmed: $confirmedBookings\nCancelled: $cancelledBookings\nCompleted: $completedBookings")
                ->description('Distribution by status')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
                
            Stat::make('Total Booking Value', 'Rp ' . number_format($totalBookingValue, 0, ',', '.'))
                ->description('Total value of all bookings')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
                
            Stat::make('Upcoming Bookings (7 days)', $upcomingBookings)
                ->description('Check-ins in the next week')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),
        ];
    }
}