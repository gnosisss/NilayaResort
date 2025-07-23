<?php

namespace App\Filament\AdminResources\CategoryResource\Pages;

use App\Filament\AdminResources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}