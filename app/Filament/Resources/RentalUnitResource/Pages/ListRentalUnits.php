<?php

namespace App\Filament\Resources\RentalUnitResource\Pages;

use App\Filament\Resources\RentalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentalUnits extends ListRecords
{
    protected static string $resource = RentalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
