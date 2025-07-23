<?php

namespace App\Filament\AdminResources\PropertyPurchaseResource\Pages;

use App\Filament\AdminResources\PropertyPurchaseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyPurchase extends ViewRecord
{
    protected static string $resource = PropertyPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}