<?php

namespace App\Filament\AdminResources\PropertyPurchaseResource\RelationManagers;

use App\Models\PropertyDocument;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('document_type')
                    ->label('Document Type')
                    ->options(PropertyDocument::$documentTypes)
                    ->required(),
                    
                FileUpload::make('file_path')
                    ->label('Document File')
                    ->directory('property-documents')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(5120) // 5MB
                    ->required(),
                    
                TextInput::make('file_name')
                    ->label('File Name')
                    ->maxLength(255)
                    ->required(),
                    
                TextInput::make('file_extension')
                    ->label('File Extension')
                    ->maxLength(10)
                    ->required(),
                    
                TextInput::make('file_size')
                    ->label('File Size')
                    ->maxLength(20)
                    ->required(),
                    
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),
                    
                Textarea::make('notes')
                    ->label('Notes')
                    ->maxLength(1000),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('document_type')
            ->columns([
                TextColumn::make('document_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('document_type')
                    ->searchable()
                    ->sortable()
                    ->label('Document Type'),
                    
                TextColumn::make('file_name')
                    ->searchable()
                    ->sortable()
                    ->label('File Name'),
                    
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ])
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}