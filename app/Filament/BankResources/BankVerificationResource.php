<?php

namespace App\Filament\BankResources;

use App\Filament\BankResources\BankVerificationResource\Pages;
use App\Models\BankVerification;
use App\Models\PropertyDocument;
use App\Models\PropertyPurchase;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentReview;

class BankVerificationResource extends Resource
{
    protected static ?string $model = BankVerification::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    
    protected static ?string $navigationGroup = 'Property Management';
    
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dasar')
                    ->schema([
                        Select::make('purchase_id')
                            ->label('Property Purchase')
                            ->options(PropertyPurchase::all()->pluck('purchase_code', 'purchase_id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(function (Set $set) {
                                $set('credit_score', null);
                            }),
                            
                        Select::make('bank_user_id')
                            ->label('Bank Officer')
                            ->options(User::where('role', 'bank')->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(auth()?->user()?->id),
                    ]),
                    
                Section::make('Penilaian Dokumen')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('document_status')
                                    ->label('Status Dokumen')
                                    ->options(BankVerification::$documentStatuses)
                                    ->required()
                                    ->default('pending'),
                                    
                                TextInput::make('credit_score')
                                    ->label('Skor Kredit')
                                    ->numeric()
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->helperText('Skor dihitung otomatis berdasarkan kelengkapan dokumen')
                                    ->disabled()
                                    ->dehydrated(),
                            ]),
                            
                        Repeater::make('document_review')
                            ->label('Penilaian Dokumen')
                            ->schema([
                                Select::make('document_type')
                                    ->label('Jenis Dokumen')
                                    ->options(PropertyDocument::$documentTypes)
                                    ->required(),
                                    
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'accepted' => 'Diterima',
                                        'revision' => 'Perlu Revisi',
                                        'rejected' => 'Ditolak',
                                    ])
                                    ->required()
                                    ->default('accepted'),
                                    
                                Textarea::make('notes')
                                    ->label('Catatan')
                                    ->placeholder('Berikan catatan untuk dokumen ini')
                                    ->visible(fn (Get $get) => in_array($get('status'), ['revision', 'rejected']))
                                    ->required(fn (Get $get) => in_array($get('status'), ['revision', 'rejected'])),
                            ])
                            ->columns(3)
                            ->itemLabel(fn (array $state): ?string => $state['document_type'] ?? null)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                // Calculate credit score based on document completeness
                                $documents = $get('document_review');
                                $totalDocuments = count($documents);
                                
                                if ($totalDocuments === 0) {
                                    $set('credit_score', 0);
                                    return;
                                }
                                
                                $acceptedCount = 0;
                                $revisionCount = 0;
                                $rejectedCount = 0;
                                
                                foreach ($documents as $document) {
                                    if ($document['status'] === 'accepted') {
                                        $acceptedCount++;
                                    } elseif ($document['status'] === 'revision') {
                                        $revisionCount++;
                                    } elseif ($document['status'] === 'rejected') {
                                        $rejectedCount++;
                                    }
                                }
                                
                                // Calculate score: accepted documents give full points
                                // documents needing revision give half points
                                // rejected documents give no points
                                $score = (($acceptedCount * 1.0) + ($revisionCount * 0.5)) / $totalDocuments * 100;
                                $set('credit_score', round($score, 2));
                                
                                // Update document status based on document review
                                if ($rejectedCount > 0) {
                                    $set('document_status', 'rejected');
                                } elseif ($revisionCount > 0) {
                                    $set('document_status', 'revision');
                                } elseif ($acceptedCount === $totalDocuments) {
                                    $set('document_status', 'accepted');
                                } else {
                                    $set('document_status', 'pending');
                                }
                            }),
                            
                        Textarea::make('revision_notes')
                            ->label('Catatan Revisi')
                            ->placeholder('Berikan catatan umum untuk revisi dokumen')
                            ->visible(fn (Get $get) => $get('document_status') === 'revision'),
                    ]),
                    
                Section::make('Keputusan Kredit')
                    ->schema([
                        Toggle::make('documents_verified')
                            ->label('Dokumen Terverifikasi')
                            ->default(false)
                            ->disabled(fn (Get $get) => $get('document_status') !== 'accepted'),
                            
                        Toggle::make('credit_approved')
                            ->label('Kredit Disetujui')
                            ->default(false)
                            ->disabled(fn (Get $get) => !$get('documents_verified')),
                            
                        TextInput::make('approved_amount')
                            ->label('Jumlah Disetujui')
                            ->numeric()
                            ->prefix('Rp')
                            ->step(0.01)
                            ->enabled(fn (Get $get) => !$get('credit_approved')),
                            
                        Textarea::make('verification_notes')
                            ->label('Catatan Verifikasi')
                            ->maxLength(1000),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('verification_id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('propertyPurchase.purchase_code')
                    ->searchable()
                    ->sortable()
                    ->label('Purchase Code'),
                    
                TextColumn::make('propertyPurchase.rentalUnit.name')
                    ->searchable()
                    ->sortable()
                    ->label('Property'),
                    
                TextColumn::make('bankUser.name')
                    ->searchable()
                    ->sortable()
                    ->label('Bank Officer'),
                    
                IconColumn::make('documents_verified')
                    ->boolean()
                    ->label('Docs Verified'),
                    
                IconColumn::make('credit_approved')
                    ->boolean()
                    ->label('Credit Approved'),
                    
                BadgeColumn::make('document_status')
                    ->colors([
                        'danger' => 'rejected',
                        'warning' => 'revision',
                        'success' => 'accepted',
                        'secondary' => 'pending',
                    ])
                    ->sortable()
                    ->searchable()
                    ->label('Status Dokumen'),
                    
                TextColumn::make('credit_score')
                    ->sortable()
                    ->label('Skor Kredit')
                    ->formatStateUsing(fn (string $state): string => $state . '%'),
                    
                TextColumn::make('approved_amount')
                    ->money('IDR')
                    ->sortable()
                    ->label('Approved Amount'),
                    
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
    
    /**
     * Calculate credit score based on document completeness
     */
    public static function calculateCreditScore(int $purchaseId): float
    {
        $documents = PropertyDocument::where('purchase_id', $purchaseId)->get();
        $totalDocuments = count($documents);
        
        if ($totalDocuments === 0) {
            return 0;
        }
        
        $acceptedCount = $documents->where('status', 'verified')->count();
        $pendingCount = $documents->where('status', 'pending')->count();
        $rejectedCount = $documents->where('status', 'rejected')->count();
        
        // Calculate score: verified documents give full points
        // pending documents give half points
        // rejected documents give no points
        $score = (($acceptedCount * 1.0) + ($pendingCount * 0.5)) / $totalDocuments * 100;
        
        return round($score, 2);
    }
    
    /**
     * Save document reviews from form data
     */
    public static function saveDocumentReviews(BankVerification $record, array $data): void
    {
        // Delete existing reviews for this verification
        DocumentReview::where('verification_id', $record->verification_id)->delete();
        
        // If no document reviews were submitted, return early
        if (!isset($data['document_review']) || empty($data['document_review'])) {
            return;
        }
        
        // Create new document reviews
        foreach ($data['document_review'] as $review) {
            // Find the document if it exists
            $document = PropertyDocument::where('purchase_id', $record->purchase_id)
                ->where('document_type', $review['document_type'])
                ->first();
                
            DocumentReview::create([
                'verification_id' => $record->verification_id,
                'document_id' => $document?->document_id,
                'document_type' => $review['document_type'],
                'status' => $review['status'],
                'notes' => $review['notes'] ?? null,
            ]);
        }
        
        // Update the bank verification with calculated credit score and document status
        $record->credit_score = $record->calculateCreditScore();
        $record->document_status = $record->determineDocumentStatus();
        $record->save();
    }

    /**
     * Hook into the create operation
     */
    public static function afterCreate(BankVerification $record, array $data): void
    {
        self::saveDocumentReviews($record, $data);
        
        Notification::make()
            ->title('Bank verification created successfully')
            ->body('Document reviews have been saved and credit score calculated.')
            ->success()
            ->send();
    }
    
    /**
     * Hook into the update operation
     */
    public static function afterUpdate(BankVerification $record, array $data): void
    {
        self::saveDocumentReviews($record, $data);
        
        Notification::make()
            ->title('Bank verification updated successfully')
            ->body('Document reviews have been updated and credit score recalculated.')
            ->success()
            ->send();
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBankVerifications::route('/'),
            'create' => Pages\CreateBankVerification::route('/create'),
            'edit' => Pages\EditBankVerification::route('/{record}/edit'),
        ];
    }
}