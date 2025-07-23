<?php

namespace App\Filament\AdminResources\BankVerificationResource\Pages;

use App\Filament\AdminResources\BankVerificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBankVerifications extends ListRecords
{
    protected static string $resource = BankVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}