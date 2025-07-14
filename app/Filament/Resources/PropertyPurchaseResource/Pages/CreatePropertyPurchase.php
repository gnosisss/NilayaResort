<?php

namespace App\Filament\Resources\PropertyPurchaseResource\Pages;

use App\Filament\Resources\PropertyPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePropertyPurchase extends CreateRecord
{
    protected static string $resource = PropertyPurchaseResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}