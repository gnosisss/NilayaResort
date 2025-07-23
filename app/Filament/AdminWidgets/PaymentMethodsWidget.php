<?php

namespace App\Filament\AdminWidgets;

use App\Models\PaymentTransaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentMethodsWidget extends ChartWidget
{
    protected static ?string $heading = 'Payment Methods Distribution';
    
    protected static ?int $sort = 6;
    
    protected function getData(): array
    {
        $paymentMethods = PaymentTransaction::select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('payment_method')
            ->get()
            ->map(function ($item) {
                return [
                    'method' => Str::title(str_replace('_', ' ', $item->payment_method)),
                    'count' => $item->count,
                    'amount' => $item->total_amount,
                ];
            });
        
        return [
            'datasets' => [
                [
                    'label' => 'Payment Methods',
                    'data' => $paymentMethods->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                    ],
                ],
            ],
            'labels' => $paymentMethods->pluck('method')->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'doughnut';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {\n"
                            . "    return context.label + ': ' + context.raw + ' transactions';\n"
                            . "}",
                    ],
                ],
            ],
        ];
    }
}