<?php

namespace App\Filament\AdminResources\PropertyDocumentResource\Pages;

use App\Filament\AdminResources\PropertyDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPropertyDocuments extends ListRecords
{
    protected static string $resource = PropertyDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}