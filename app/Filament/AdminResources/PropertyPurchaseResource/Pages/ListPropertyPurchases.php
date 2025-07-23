<?php

namespace App\Filament\AdminResources\PropertyPurchaseResource\Pages;

use App\Filament\AdminResources\PropertyPurchaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPropertyPurchases extends ListRecords
{
    protected static string $resource = PropertyPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}