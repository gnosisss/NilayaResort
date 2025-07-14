<?php

namespace App\Filament\CustomerResources\BookingResource\Pages;

use App\Filament\CustomerResources\BookingResource;
use Filament\Resources\Pages\ListRecords;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;
}