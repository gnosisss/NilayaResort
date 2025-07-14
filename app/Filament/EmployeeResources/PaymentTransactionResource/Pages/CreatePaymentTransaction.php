<?php

namespace App\Filament\EmployeeResources\PaymentTransactionResource\Pages;

use App\Filament\EmployeeResources\PaymentTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentTransaction extends CreateRecord
{
    protected static string $resource = PaymentTransactionResource::class;
}