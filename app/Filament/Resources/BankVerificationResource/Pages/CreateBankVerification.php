<?php

namespace App\Filament\Resources\BankVerificationResource\Pages;

use App\Filament\Resources\BankVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBankVerification extends CreateRecord
{
    protected static string $resource = BankVerificationResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['bank_user_id'] = auth()->id();
        
        return $data;
    }
}