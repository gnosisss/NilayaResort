<?php

namespace App\Filament\AdminResources\ImageResource\Pages;

use App\Filament\AdminResources\ImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImage extends CreateRecord
{
    protected static string $resource = ImageResource::class;
}