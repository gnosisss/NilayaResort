<?php

namespace App\Filament\Resources\PropertyDocumentResource\Pages;

use App\Filament\Resources\PropertyDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePropertyDocument extends CreateRecord
{
    protected static string $resource = PropertyDocumentResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['file_path']) && !empty($data['file_path'])) {
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