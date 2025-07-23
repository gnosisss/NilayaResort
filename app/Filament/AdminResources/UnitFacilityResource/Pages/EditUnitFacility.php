<?php

namespace App\Filament\AdminResources\UnitFacilityResource\Pages;

use App\Filament\AdminResources\UnitFacilityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUnitFacility extends EditRecord
{
    protected static string $resource = UnitFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}