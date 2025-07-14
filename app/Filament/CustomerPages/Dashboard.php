<?php

namespace App\Filament\CustomerPages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.customer.pages.dashboard';
    
    public function getTitle(): string 
    {
        return 'Customer Dashboard';
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            // Customer-specific widgets
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Customer-specific widgets
        ];
    }
}