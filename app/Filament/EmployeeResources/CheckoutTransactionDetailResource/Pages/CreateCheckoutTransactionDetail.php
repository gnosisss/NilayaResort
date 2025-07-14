<?php

namespace App\Filament\EmployeeResources\CheckoutTransactionDetailResource\Pages;

use App\Filament\EmployeeResources\CheckoutTransactionDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCheckoutTransactionDetail extends CreateRecord
{
    protected static string $resource = CheckoutTransactionDetailResource::class;
}