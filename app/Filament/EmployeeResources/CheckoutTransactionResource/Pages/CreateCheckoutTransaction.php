<?php

namespace App\Filament\EmployeeResources\CheckoutTransactionResource\Pages;

use App\Filament\EmployeeResources\CheckoutTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCheckoutTransaction extends CreateRecord
{
    protected static string $resource = CheckoutTransactionResource::class;
}