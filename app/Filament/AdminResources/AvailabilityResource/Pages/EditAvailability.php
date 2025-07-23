<?php

namespace App\Filament\AdminResources\AvailabilityResource\Pages;

use App\Filament\AdminResources\AvailabilityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAvailability extends EditRecord
{
    protected static string $resource = AvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}