<?php

namespace App\Filament\Resources\PropertyDocumentResource\Pages;

use App\Filament\Resources\PropertyDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyDocument extends EditRecord
{
    protected static string $resource = PropertyDocumentResource::class;

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
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['file_path']) && $data['file_path'] !== $this->getRecord()->file_path) {
            $file = get_file_from_storage($data['file_path']);
            
            if ($file) {
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_extension'] = $file->getClientOriginalExtension();
                $data['file_size'] = $file->getSize();
            }
        }
        
        return $data;
    }
}