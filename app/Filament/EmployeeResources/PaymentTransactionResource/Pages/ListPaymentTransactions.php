<?php

namespace App\Filament\EmployeeResources\PaymentTransactionResource\Pages;

use App\Filament\EmployeeResources\PaymentTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentTransactions extends ListRecords
{
    protected static string $resource = PaymentTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}