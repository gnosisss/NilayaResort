<?php

namespace App\Filament\Resources\UnitFacilityResource\Pages;

use App\Filament\Resources\UnitFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnitFacility extends EditRecord
{
    protected static string $resource = UnitFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}