<?php

namespace App\Filament\AdminWidgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected function getStats(): array
    {
        // Get total users count
        $totalUsers = User::count();
        
        // Get users by role
        $admins = User::where('role', 'admin')->count();
        $employees = User::where('role', 'employee')->count();
        $customers = User::where('role', 'customer')->count();
        $bankOfficers = User::where('role', 'bank_officer')->count();
        
        // Get new users in the last 30 days
        $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();
        
        // Calculate percentage of new users
        $newUsersPercentage = $totalUsers > 0 ? round(($newUsers / $totalUsers) * 100, 1) : 0;
        
        return [
            Stat::make('Total Users', $totalUsers)
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('User Roles', "Admins: $admins\nEmployees: $employees\nCustomers: $customers\nBank Officers: $bankOfficers")
                ->description('Distribution by role')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
                
            Stat::make('New Users (30 days)', $newUsers)
                ->description("$newUsersPercentage% of total users")
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),
        ];
    }
}