<?php

namespace App\Filament\AdminResources\PropertyPurchaseResource\Pages;

use App\Filament\AdminResources\PropertyPurchaseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPropertyPurchase extends EditRecord
{
    protected static string $resource = PropertyPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}