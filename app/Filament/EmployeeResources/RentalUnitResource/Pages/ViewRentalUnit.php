<?php

namespace App\Filament\EmployeeResources\RentalUnitResource\Pages;

use App\Filament\EmployeeResources\RentalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRentalUnit extends ViewRecord
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}