<?php

namespace App\Filament\Resources\CheckoutTransactionDetailResource\Pages;

use App\Filament\Resources\CheckoutTransactionDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCheckoutTransactionDetail extends CreateRecord
{
    protected static string $resource = CheckoutTransactionDetailResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}