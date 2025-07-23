<?php

namespace App\Filament\AdminResources\UnitFacilityResource\Pages;

use App\Filament\AdminResources\UnitFacilityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnitFacilities extends ListRecords
{
    protected static string $resource = UnitFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}