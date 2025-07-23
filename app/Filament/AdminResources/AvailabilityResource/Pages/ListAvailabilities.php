<?php

namespace App\Filament\AdminResources\AvailabilityResource\Pages;

use App\Filament\AdminResources\AvailabilityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAvailabilities extends ListRecords
{
    protected static string $resource = AvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}