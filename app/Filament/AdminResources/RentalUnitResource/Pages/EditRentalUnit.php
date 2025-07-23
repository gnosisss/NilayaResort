<?php

namespace App\Filament\AdminResources\RentalUnitResource\Pages;

use App\Filament\AdminResources\RentalUnitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRentalUnit extends EditRecord
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}