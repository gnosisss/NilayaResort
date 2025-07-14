<?php

namespace App\Filament\Resources\BankVerificationResource\Pages;

use App\Filament\Resources\BankVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankVerifications extends ListRecords
{
    protected static string $resource = BankVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}