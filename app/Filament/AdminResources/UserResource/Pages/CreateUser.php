<?php

namespace App\Filament\AdminResources\UserResource\Pages;

use App\Filament\AdminResources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}