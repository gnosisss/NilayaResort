<?php

namespace App\Filament\AdminWidgets;

use App\Models\Booking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BookingTrendsWidget extends ChartWidget
{
    protected static ?string $heading = 'Booking Trends';
    
    protected static ?int $sort = 5;
    
    protected int | string | array $columnSpan = 'full';
    
    protected function getData(): array
    {
        $bookingsByMonth = $this->getBookingsByMonth();
        $bookingsByStatus = $this->getBookingsByStatus();
        
        return [
            'datasets' => [
                [
                    'label' => 'Monthly Bookings',
                    'data' => array_values($bookingsByMonth['counts']),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
                [
                    'label' => 'Monthly Revenue (in millions Rp)',
                    'data' => array_values($bookingsByMonth['revenue']),
                    'backgroundColor' => '#4BC0C0',
                    'borderColor' => '#4BC0C0',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => array_values($bookingsByMonth['labels']),
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Bookings',
                    ],
                    'beginAtZero' => true,
                ],
                'y1' => [
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue (in millions Rp)',
                    ],
                    'beginAtZero' => true,
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
    
    private function getBookingsByMonth(): array
    {
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
        
        $bookings = Booking::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        $labels = [];
        $counts = [];
        $revenue = [];
        
        // Create array with all months (even empty ones)
        $currentDate = Carbon::now();
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths($i);
            $yearMonth = $date->format('Y-m');
            $monthName = $date->format('M Y');
            
            $labels[$yearMonth] = $monthName;
            $counts[$yearMonth] = 0;
            $revenue[$yearMonth] = 0;
        }
        
        // Fill with actual data
        foreach ($bookings as $booking) {
            $yearMonth = sprintf('%04d-%02d', $booking->year, $booking->month);
            if (isset($counts[$yearMonth])) {
                $counts[$yearMonth] = $booking->count;
                $revenue[$yearMonth] = round($booking->revenue / 1000000, 2); // Convert to millions
            }
        }
        
        // Reverse to show chronological order
        $labels = array_reverse($labels);
        $counts = array_reverse($counts);
        $revenue = array_reverse($revenue);
        
        return [
            'labels' => $labels,
            'counts' => $counts,
            'revenue' => $revenue,
        ];
    }
    
    private function getBookingsByStatus(): array
    {
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        $counts = [];
        
        foreach ($statuses as $status) {
            $counts[$status] = Booking::where('status', $status)->count();
        }
        
        return [
            'labels' => array_map('ucfirst', $statuses),
            'counts' => array_values($counts),
        ];
    }
}