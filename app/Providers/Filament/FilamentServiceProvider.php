<?php

namespace App\Providers\Filament;

use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\EmployeePanelProvider;
use App\Providers\Filament\BankOfficerPanelProvider;
use App\Providers\Filament\CustomerPanelProvider;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register all panel providers
        $this->app->singleton(AdminPanelProvider::class);
        $this->app->singleton(EmployeePanelProvider::class);
        $this->app->singleton(BankOfficerPanelProvider::class);
        $this->app->singleton(CustomerPanelProvider::class);
    }
}