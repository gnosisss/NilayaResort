<?php

namespace App\Filament\Resources\BankVerificationResource\Pages;

use App\Filament\Resources\BankVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBankVerification extends EditRecord
{
    protected static string $resource = BankVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function afterSave(): void
    {
        $record = $this->getRecord();
        $propertyPurchase = $record->propertyPurchase;
        
        // Update property purchase status based on verification
        if ($record->documents_verified && !$record->credit_approved) {
            $propertyPurchase->status = 'documents_verified';
        } elseif ($record->documents_verified && $record->credit_approved) {
            $propertyPurchase->status = 'credit_approved';
        }
        
        $propertyPurchase->save();
    }
}