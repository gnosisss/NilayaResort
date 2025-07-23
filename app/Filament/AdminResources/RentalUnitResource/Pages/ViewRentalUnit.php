<?php

namespace App\Filament\AdminResources\RentalUnitResource\Pages;

use App\Filament\AdminResources\RentalUnitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRentalUnit extends ViewRecord
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}