<?php

namespace App\Filament\AdminResources\PaymentTransactionResource\Pages;

use App\Filament\AdminResources\PaymentTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentTransaction extends EditRecord
{
    protected static string $resource = PaymentTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}