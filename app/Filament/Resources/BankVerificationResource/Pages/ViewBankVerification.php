<?php

namespace App\Filament\Resources\BankVerificationResource\Pages;

use App\Filament\Resources\BankVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBankVerification extends ViewRecord
{
    protected static string $resource = BankVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}