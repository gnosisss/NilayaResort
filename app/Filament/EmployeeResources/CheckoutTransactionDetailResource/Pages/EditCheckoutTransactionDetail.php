<?php

namespace App\Filament\EmployeeResources\CheckoutTransactionDetailResource\Pages;

use App\Filament\EmployeeResources\CheckoutTransactionDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckoutTransactionDetail extends EditRecord
{
    protected static string $resource = CheckoutTransactionDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}