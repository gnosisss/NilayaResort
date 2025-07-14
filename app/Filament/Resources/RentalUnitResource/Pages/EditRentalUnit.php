<?php

namespace App\Filament\Resources\RentalUnitResource\Pages;

use App\Filament\Resources\RentalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentalUnit extends EditRecord
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
