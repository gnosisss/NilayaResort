<?php

namespace App\Filament\Resources\CheckoutTransactionResource\Pages;

use App\Filament\Resources\CheckoutTransactionResource;
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
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}