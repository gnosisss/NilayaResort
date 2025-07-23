<?php

namespace App\Filament\AdminResources\PaymentTransactionResource\Pages;

use App\Filament\AdminResources\PaymentTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentTransaction extends CreateRecord
{
    protected static string $resource = PaymentTransactionResource::class;
}