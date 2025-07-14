<?php

namespace App\Filament\Resources\PropertyPurchaseResource\Pages;

use App\Filament\Resources\PropertyPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyPurchase extends ViewRecord
{
    protected static string $resource = PropertyPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}