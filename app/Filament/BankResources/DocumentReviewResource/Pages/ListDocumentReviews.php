<?php

namespace App\Filament\BankResources\DocumentReviewResource\Pages;

use App\Filament\BankResources\DocumentReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocumentReviews extends ListRecords
{
    protected static string $resource = DocumentReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}