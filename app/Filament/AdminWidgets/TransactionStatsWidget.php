<?php

namespace App\Filament\AdminWidgets;

use App\Models\CheckoutTransaction;
use App\Models\PaymentTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TransactionStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        // Get total transactions amount
        $totalPaymentAmount = PaymentTransaction::sum('amount');
        
        // Get total transactions count
        $totalTransactions = PaymentTransaction::count();
        
        // Get pending payments count
        $pendingPayments = PaymentTransaction::where('payment_status', 'pending')->count();
        
        // Get completed payments count
        $completedPayments = PaymentTransaction::where('payment_status', 'completed')->count();
        
        // Get payment method distribution
        $paymentMethods = PaymentTransaction::select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method')
            ->toArray();
            
        $paymentMethodsText = '';
        foreach ($paymentMethods as $method => $count) {
            $methodName = ucwords(str_replace('_', ' ', $method));
            $paymentMethodsText .= "$methodName: $count\n";
        }
        
        return [
            Stat::make('Total Transaction Amount', 'Rp ' . number_format($totalPaymentAmount, 0, ',', '.'))
                ->description('Total value of all transactions')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Total Transactions', $totalTransactions)
                ->description('Number of transactions')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
                
            Stat::make('Payment Status', "Completed: $completedPayments\nPending: $pendingPayments")
                ->description('Transaction status distribution')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($completedPayments > $pendingPayments ? 'success' : 'warning'),
                
            Stat::make('Payment Methods', $paymentMethodsText)
                ->description('Distribution by payment method')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('info'),
        ];
    }
}