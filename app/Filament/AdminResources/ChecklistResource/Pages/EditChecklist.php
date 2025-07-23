<?php

namespace App\Filament\AdminResources\ChecklistResource\Pages;

use App\Filament\AdminResources\ChecklistResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChecklist extends EditRecord
{
    protected static string $resource = ChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}