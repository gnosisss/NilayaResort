<?php

namespace App\Filament\EmployeeResources\RentalUnitResource\Pages;

use App\Filament\EmployeeResources\RentalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentalUnits extends ListRecords
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}