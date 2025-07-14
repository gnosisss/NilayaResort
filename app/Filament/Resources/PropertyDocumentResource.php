<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyDocumentResource\Pages;
use App\Models\PropertyDocument;
use App\Policies\PropertyDocumentPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyDocumentResource extends Resource
{
    protected static ?string $model = PropertyDocument::class;
    
    protected static ?string $modelLabel = 'Property Document';
    
    protected static ?string $pluralModelLabel = 'Property Documents';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Property Documents';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 30;
    
    protected static ?string $recordTitleAttribute = 'document_id';
    
    public static function getNavigationBadge(): ?string
    {
        if (Auth::user()->isBankOfficer()) {
            return static::getModel()::where('status', 'pending')
                ->count();
        }
        
        return null;
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        if (Auth::user()->isBankOfficer()) {
            return static::getModel()::where('status', 'pending')
                ->count() > 0
                    ? 'warning'
                    : 'success';
        }
        
        return null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->default(fn () => Auth::user()->isBankOfficer() ? null : Auth::id())
                    ->disabled(fn () => !Auth::user()->isBankOfficer() && Auth::check())
                    ->searchable(),
                Forms\Components\Select::make('document_type')
                    ->options(PropertyDocument::$documentTypes)
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Document File')
                    ->required()
                    ->disk('public')
                    ->directory('property-documents')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(5120), // 5MB
                Forms\Components\TextInput::make('file_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_extension')
                    ->maxLength(10),
                Forms\Components\TextInput::make('file_size')
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending')
                    ->disabled(fn (PropertyDocument $record = null) => 
                        !Auth::user()->isBankOfficer() || 
                        ($record && $record->status === 'verified')
                    ),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->disabled(fn (PropertyDocument $record = null) => 
                        !Auth::user()->isBankOfficer() && 
                        $record && 
                        $record->status !== 'pending'
                    ),
                    
                Forms\Components\Select::make('purchase_id')
                    ->relationship('propertyPurchase', 'purchase_code')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('document_type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_extension')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_size')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn (int $state): string => number_format($state / 1024, 2) . ' KB'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => 
                        match ($state) {
                            'rejected' => 'danger',
                            'pending' => 'warning',
                            'verified' => 'success',
                            default => 'secondary',
                        }
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type')
                    ->options(PropertyDocument::$documentTypes),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (PropertyDocument $record) => 
                        Auth::user()->isBankOfficer() || 
                        (Auth::id() === $record->user_id && $record->status === 'pending')
                    ),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (PropertyDocument $record) => 
                        Auth::user()->isBankOfficer() || 
                        (Auth::id() === $record->user_id && $record->status === 'pending')
                    ),
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (PropertyDocument $record) => Storage::disk('public')->url($record->file_path))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('verify')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (PropertyDocument $record) => 
                        Auth::user()->isBankOfficer() && $record->status === 'pending'
                    )
                    ->action(function (PropertyDocument $record) {
                        $record->status = 'verified';
                        $record->save();
                    }),
                Tables\Actions\Action::make('reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (PropertyDocument $record) => 
                        Auth::user()->isBankOfficer() && $record->status === 'pending'
                    )
                    ->action(function (PropertyDocument $record, array $data) {
                        $record->status = 'rejected';
                        $record->notes = $data['notes'] ?? $record->notes;
                        $record->save();
                    })
                    ->form([
                        Forms\Components\Textarea::make('notes')
                            ->label('Rejection Reason')
                            ->required(),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'view' => Pages\ViewPropertyDocument::route('/{record}'),
        ];
    }
}