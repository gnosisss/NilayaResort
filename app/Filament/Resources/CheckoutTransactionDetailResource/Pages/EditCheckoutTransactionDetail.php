<?php

namespace App\Filament\Resources\CheckoutTransactionDetailResource\Pages;

use App\Filament\Resources\CheckoutTransactionDetailResource;
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
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}