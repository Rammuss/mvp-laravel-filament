<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyLeadResource\Pages;
use App\Models\PropertyLead;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PropertyLeadResource extends Resource
{
    protected static ?string $model = PropertyLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-incoming';

    protected static ?string $navigationLabel = 'Property Leads';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('property_id')
                    ->relationship('property', 'title')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'closed' => 'Closed',
                    ])
                    ->default('new')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Property')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function ($state): string {
                        if ($state === 'new') {
                            return 'danger';
                        }

                        if ($state === 'contacted') {
                            return 'warning';
                        }

                        return 'success';
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'closed' => 'Closed',
                    ])
                    ->default('new'),
            ])
            ->actions([
                Tables\Actions\Action::make('markContacted')
                    ->label('Mark Contacted')
                    ->icon('heroicon-o-phone-outgoing')
                    ->requiresConfirmation()
                    ->visible(function ($record): bool {
                        return $record->status === 'new';
                    })
                    ->action(function ($record): void {
                        $record->update([
                            'status' => 'contacted',
                        ]);
                    }),
                Tables\Actions\Action::make('markClosed')
                    ->label('Mark Closed')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(function ($record): bool {
                        return $record->status === 'contacted';
                    })
                    ->action(function ($record): void {
                        $record->update([
                            'status' => 'closed',
                        ]);
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPropertyLeads::route('/'),
            'create' => Pages\CreatePropertyLead::route('/create'),
            'edit' => Pages\EditPropertyLead::route('/{record}/edit'),
        ];
    }
}
