<?php

namespace App\Filament\CustomerResources\PaymentResource\Pages;

use App\Filament\CustomerResources\PaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}