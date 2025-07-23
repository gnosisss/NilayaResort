<?php

namespace App\Filament\AdminResources\CheckoutTransactionResource\Pages;

use App\Filament\AdminResources\CheckoutTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCheckoutTransaction extends CreateRecord
{
    protected static string $resource = CheckoutTransactionResource::class;
}