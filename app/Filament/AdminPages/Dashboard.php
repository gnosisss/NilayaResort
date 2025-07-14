<?php

namespace App\Filament\AdminPages;

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
            // Admin-specific widgets
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Admin-specific widgets
        ];
    }
}