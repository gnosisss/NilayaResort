<?php

namespace App\Filament\BankResources\DocumentReviewResource\Pages;

use App\Filament\BankResources\DocumentReviewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDocumentReview extends ViewRecord
{
    protected static string $resource = DocumentReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}