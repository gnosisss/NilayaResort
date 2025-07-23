<?php

namespace App\Filament\AdminResources\RentalUnitResource\Pages;

use App\Filament\AdminResources\RentalUnitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRentalUnits extends ListRecords
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}