<?php

namespace App\Filament\AdminResources\PaymentTransactionResource\Pages;

use App\Filament\AdminResources\PaymentTransactionResource;
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