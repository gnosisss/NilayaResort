<?php

namespace App\Filament\AdminResources\ChecklistResource\Pages;

use App\Filament\AdminResources\ChecklistResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChecklists extends ListRecords
{
    protected static string $resource = ChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}