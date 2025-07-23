<?php

namespace App\Filament\AdminResources\PaymentResource\Pages;

use App\Filament\AdminResources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
}