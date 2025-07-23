<?php

namespace App\Filament\BankResources\DocumentReviewResource\Pages;

use App\Filament\BankResources\DocumentReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDocumentReview extends EditRecord
{
    protected static string $resource = DocumentReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}