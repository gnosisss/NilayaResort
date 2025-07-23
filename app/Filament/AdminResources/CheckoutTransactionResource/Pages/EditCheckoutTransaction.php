<?php

namespace App\Filament\AdminResources\CheckoutTransactionResource\Pages;

use App\Filament\AdminResources\CheckoutTransactionResource;
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