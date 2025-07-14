<?php

namespace App\Filament\EmployeeResources\AvailabilityResource\Pages;

use App\Filament\EmployeeResources\AvailabilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvailability extends EditRecord
{
    protected static string $resource = AvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}