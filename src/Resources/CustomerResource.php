<?php

namespace thianpri\FilamentSertifikat\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use thianpri\FilamentSertifikat\Models\Customer;
use thianpri\FilamentSertifikat\Resources\CustomerResource\Pages;
use thianpri\FilamentSertifikat\Traits\HasContentEditor;

class CustomerResource extends Resource
{
    use HasContentEditor;

    protected static ?string $model = Customer::class;

    protected static ?string $slug = 'sertifikat/customers';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Sertifikat';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->unique(Customer::class, 'email', fn ($record) => $record),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->maxSize(5120)
                            ->directory('blog')
                            ->disk('public')
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                        self::getContentEditor('bio'),
                        Forms\Components\TextInput::make('no_hp')
                            ->label('GitHub'),
                        Forms\Components\TextInput::make('no_identitas')
                            ->label('Twitter'),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (
                                ?Customer $record
                            ): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (
                                ?Customer $record
                            ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->rounded(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('GitHub'),
                Tables\Columns\TextColumn::make('no_identitas')
                    ->label('Twitter'),
            ])
            ->filters([
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
