<?php

namespace App\Filament\Resources\UnitFacilityResource\Pages;

use App\Filament\Resources\UnitFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnitFacilities extends ListRecords
{
    protected static string $resource = UnitFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}