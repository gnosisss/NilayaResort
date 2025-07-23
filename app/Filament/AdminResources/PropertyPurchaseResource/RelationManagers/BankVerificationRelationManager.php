<?php

namespace App\Filament\AdminResources\PropertyPurchaseResource\RelationManagers;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class BankVerificationRelationManager extends RelationManager
{
    protected static string $relationship = 'bankVerification';

    protected static ?string $recordTitleAttribute = 'verification_id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bank_user_id')
                    ->label('Bank Officer')
                    ->options(User::where('role', 'bank')->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                Toggle::make('documents_verified')
                    ->label('Documents Verified')
                    ->default(false),
                    
                Toggle::make('credit_approved')
                    ->label('Credit Approved')
                    ->default(false),
                    
                TextInput::make('credit_score')
                    ->label('Credit Score')
                    ->numeric()
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(100),
                    
                TextInput::make('approved_amount')
                    ->label('Approved Amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->step(0.01),
                    
                Textarea::make('verification_notes')
                    ->label('Verification Notes')
                    ->maxLength(1000),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('verification_id')
                    ->sortable()
                    ->label('ID'),
                    
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
                    
                TextColumn::make('credit_score')
                    ->sortable()
                    ->label('Credit Score'),
                    
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
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (!isset($data['bank_user_id']) && auth()->user()->role === 'bank') {
                            $data['bank_user_id'] = auth()->id();
                        }
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