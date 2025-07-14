<?php

namespace App\Filament\BankPages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.bank.pages.dashboard';
    
    public function getTitle(): string 
    {
        return 'Bank Verification Dashboard';
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            // Bank officer-specific widgets
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Bank officer-specific widgets
        ];
    }
}