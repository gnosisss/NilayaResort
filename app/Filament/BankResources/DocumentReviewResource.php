<?php

namespace App\Filament\BankResources;

use App\Filament\BankResources\DocumentReviewResource\Pages;
use App\Models\DocumentReview;
use App\Models\BankVerification;
use App\Models\PropertyDocument;
use App\Models\PropertyPurchase;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class DocumentReviewResource extends Resource
{
    protected static ?string $model = DocumentReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    
    protected static ?string $navigationGroup = 'Bank Management';
    
    protected static ?string $navigationLabel = 'Document Reviews';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('verification_id')
                    ->label('Bank Verification')
                    ->options(BankVerification::all()->pluck('verification_id', 'verification_id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                Select::make('document_id')
                    ->label('Property Document')
                    ->options(PropertyDocument::all()->pluck('document_type', 'document_id'))
                    ->searchable()
                    ->preload(),
                    
                Select::make('document_type')
                    ->label('Document Type')
                    ->options(PropertyDocument::$documentTypes)
                    ->required(),
                    
                Select::make('status')
                    ->label('Status')
                    ->options(DocumentReview::$documentStatuses)
                    ->required()
                    ->default('accepted'),
                    
                Textarea::make('notes')
                    ->label('Notes')
                    ->placeholder('Enter notes for this document review')
                    ->maxLength(1000),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('review_id')
                    ->sortable()
                    ->searchable()
                    ->label('ID'),
                    
                TextColumn::make('bankVerification.propertyPurchase.purchase_code')
                    ->sortable()
                    ->searchable()
                    ->label('Purchase Code'),
                    
                TextColumn::make('document_type')
                    ->formatStateUsing(fn (string $state): string => PropertyDocument::$documentTypes[$state] ?? $state)
                    ->sortable()
                    ->searchable()
                    ->label('Document Type'),
                    
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'accepted',
                        'warning' => 'revision',
                        'danger' => 'rejected',
                    ])
                    ->sortable()
                    ->searchable()
                    ->label('Status'),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentReviews::route('/'),
            'create' => Pages\CreateDocumentReview::route('/create'),
            'edit' => Pages\EditDocumentReview::route('/{record}/edit'),
            'view' => Pages\ViewDocumentReview::route('/{record}'),
        ];
    }
}