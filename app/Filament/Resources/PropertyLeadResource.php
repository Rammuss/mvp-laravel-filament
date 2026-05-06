<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyLeadResource\Pages;
use App\Models\PropertyLead;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

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
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->where('status', 'new');
            })
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
                    ->color(function (string $state): string {
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
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('advanceStatus')
                    ->label(function (PropertyLead $record): string {
                        if ($record->status === 'new') {
                            return 'Mark Contacted';
                        }

                        return 'Mark Closed';
                    })
                    ->icon('heroicon-o-arrow-right')
                    ->requiresConfirmation()
                    ->visible(function (PropertyLead $record): bool {
                        return $record->status !== 'closed';
                    })
                    ->action(function (PropertyLead $record): void {
                        $nextStatus = $record->status === 'new' ? 'contacted' : 'closed';

                        $record->update([
                            'status' => $nextStatus,
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
