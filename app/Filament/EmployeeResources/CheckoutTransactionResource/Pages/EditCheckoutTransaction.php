<?php

namespace App\Filament\EmployeeResources\CheckoutTransactionResource\Pages;

use App\Filament\EmployeeResources\CheckoutTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckoutTransaction extends EditRecord
{
    protected static string $resource = CheckoutTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}