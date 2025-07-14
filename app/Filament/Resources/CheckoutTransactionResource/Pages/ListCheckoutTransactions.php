<?php

namespace App\Filament\Resources\CheckoutTransactionResource\Pages;

use App\Filament\Resources\CheckoutTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckoutTransactions extends ListRecords
{
    protected static string $resource = CheckoutTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}