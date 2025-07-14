<?php

namespace App\Filament\EmployeeResources\CheckoutTransactionDetailResource\Pages;

use App\Filament\EmployeeResources\CheckoutTransactionDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckoutTransactionDetails extends ListRecords
{
    protected static string $resource = CheckoutTransactionDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}