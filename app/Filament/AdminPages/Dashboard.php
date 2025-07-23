<?php

namespace App\Filament\AdminPages;

use App\Filament\AdminWidgets\BookingStatsWidget;
use App\Filament\AdminWidgets\BookingTrendsWidget;
use App\Filament\AdminWidgets\LatestBookingsWidget;
use App\Filament\AdminWidgets\LatestPaymentsWidget;
use App\Filament\AdminWidgets\PaymentMethodsWidget;
use App\Filament\AdminWidgets\RentalUnitStatsWidget;
use App\Filament\AdminWidgets\TransactionStatsWidget;
use App\Filament\AdminWidgets\UnitAvailabilityWidget;
use App\Filament\AdminWidgets\UserStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.admin.pages.dashboard';
    
    public function getTitle(): string 
    {
        return 'Admin Dashboard';
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            TransactionStatsWidget::class,
            UserStatsWidget::class,
            BookingStatsWidget::class,
            RentalUnitStatsWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            BookingTrendsWidget::class,
            PaymentMethodsWidget::class,
            LatestBookingsWidget::class,
            LatestPaymentsWidget::class,
            UnitAvailabilityWidget::class,
        ];
    }
}