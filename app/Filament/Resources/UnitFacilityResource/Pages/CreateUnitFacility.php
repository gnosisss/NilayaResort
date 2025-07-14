<?php

namespace App\Filament\Resources\UnitFacilityResource\Pages;

use App\Filament\Resources\UnitFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUnitFacility extends CreateRecord
{
    protected static string $resource = UnitFacilityResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}