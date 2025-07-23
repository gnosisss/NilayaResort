<?php

namespace App\Filament\AdminResources\BankVerificationResource\Pages;

use App\Filament\AdminResources\BankVerificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBankVerification extends EditRecord
{
    protected static string $resource = BankVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}