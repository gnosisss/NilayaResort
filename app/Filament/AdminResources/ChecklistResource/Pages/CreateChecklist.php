<?php

namespace App\Filament\AdminResources\ChecklistResource\Pages;

use App\Filament\AdminResources\ChecklistResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChecklist extends CreateRecord
{
    protected static string $resource = ChecklistResource::class;
}