<?php

namespace App\Filament\EmployeeResources\RentalUnitResource\Pages;

use App\Filament\EmployeeResources\RentalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentalUnit extends EditRecord
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
}