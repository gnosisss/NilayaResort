<?php

namespace App\Filament\EmployeeResources\AvailabilityResource\Pages;

use App\Filament\EmployeeResources\AvailabilityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAvailability extends CreateRecord
{
    protected static string $resource = AvailabilityResource::class;
}