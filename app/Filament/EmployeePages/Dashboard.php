<?php

namespace App\Filament\EmployeePages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.employee.pages.dashboard';
    
    public function getTitle(): string 
    {
        return 'Employee Dashboard';
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            // Employee-specific widgets
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Employee-specific widgets
        ];
    }
}