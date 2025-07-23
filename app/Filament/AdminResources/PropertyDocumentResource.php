<?php

namespace App\Filament\AdminResources;

use App\Filament\AdminResources\PropertyDocumentResource\Pages;
use App\Models\PropertyDocument;
use App\Models\PropertyPurchase;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class PropertyDocumentResource extends Resource
{
    protected static ?string $model = PropertyDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                Select::make('purchase_id')
                    ->label('Property Purchase')
                    ->options(PropertyPurchase::all()->pluck('purchase_code', 'purchase_id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),
                    
                TextColumn::make('propertyPurchase.purchase_code')
                    ->searchable()
                    ->sortable()
                    ->label('Purchase Code'),
                    
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
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPropertyDocuments::route('/'),
            'create' => Pages\CreatePropertyDocument::route('/create'),
            'edit' => Pages\EditPropertyDocument::route('/{record}/edit'),
        ];
    }
}