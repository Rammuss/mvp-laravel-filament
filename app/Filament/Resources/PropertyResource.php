<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Properties';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('operation_type')
                    ->options([
                        'sale' => 'Sale',
                        'rent' => 'Rent',
                    ])
                    ->required(),
                Forms\Components\Select::make('property_type')
                    ->options([
                        'house' => 'House',
                        'apartment' => 'Apartment',
                        'land' => 'Land',
                        'office' => 'Office',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('currency')
                    ->options([
                        'USD' => 'USD',
                        'PYG' => 'PYG',
                    ])
                    ->default('USD')
                    ->required(),
                Forms\Components\TextInput::make('bedrooms')->numeric(),
                Forms\Components\TextInput::make('bathrooms')->numeric(),
                Forms\Components\TextInput::make('area_m2')->numeric(),
                Forms\Components\TextInput::make('city')->maxLength(255),
                Forms\Components\TextInput::make('address')->maxLength(255),
                Forms\Components\TextInput::make('whatsapp_number')
                    ->label('WhatsApp number')
                    ->helperText('Ej: 595981123456 (solo numeros con codigo de pais)')
                    ->tel()
                    ->maxLength(30),
                Forms\Components\Textarea::make('short_description')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('long_description')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_featured')->default(false),
                Forms\Components\Toggle::make('is_published')->default(true),
                Forms\Components\HasManyRepeater::make('images')
                    ->relationship('images')
                    ->label('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->disk('public')
                            ->directory('properties')
                            ->preserveFilenames(false)
                            ->getUploadedFileNameForStorageUsing(
                                fn (UploadedFile $file): string => Str::uuid() . '.' . $file->getClientOriginalExtension()
                            )
                            ->required(),
                        Forms\Components\TextInput::make('alt_text')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\Toggle::make('is_cover')
                            ->default(false),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('operation_type')->sortable(),
                Tables\Columns\TextColumn::make('property_type')->sortable(),
                Tables\Columns\TextColumn::make('price')->money(fn ($record) => $record->currency)->sortable(),
                Tables\Columns\TextColumn::make('city')->searchable(),
                Tables\Columns\TextColumn::make('whatsapp_number')->label('WhatsApp')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_featured')->boolean(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
