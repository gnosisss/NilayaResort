<?php

namespace App\Filament\AdminResources\BookingResource\Pages;

use App\Filament\AdminResources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
}