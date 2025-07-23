<?php

namespace App\Filament\AdminResources\PropertyDocumentResource\Pages;

use App\Filament\AdminResources\PropertyDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPropertyDocument extends EditRecord
{
    protected static string $resource = PropertyDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}