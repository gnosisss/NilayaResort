<?php

namespace App\Filament\Resources\PropertyPurchaseResource\Pages;

use App\Filament\Resources\PropertyPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyPurchases extends ListRecords
{
    protected static string $resource = PropertyPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}