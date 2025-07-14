<?php

namespace App\Filament\Resources\CheckoutTransactionResource\Pages;

use App\Filament\Resources\CheckoutTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCheckoutTransaction extends CreateRecord
{
    protected static string $resource = CheckoutTransactionResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}