<?php

namespace App\Filament\Resources\PropertyPurchaseResource\Pages;

use App\Filament\Resources\PropertyPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyPurchase extends EditRecord
{
    protected static string $resource = PropertyPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}