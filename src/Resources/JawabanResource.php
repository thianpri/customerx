<?php

namespace thianpri\FilamentSertifikat\Resources;

use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use function now;
use thianpri\FilamentSertifikat\Models\Jawaban;
use thianpri\FilamentSertifikat\Resources\JawabanResource\Pages;

use thianpri\FilamentSertifikat\Traits\HasContentEditor;

class JawabanResource extends Resource
{
    use HasContentEditor;

    protected static ?string $model = Jawaban::class;

    protected static ?string $slug = 'sertifikat/jawaban';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Sertifikat';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->required()
                            ->unique(Jawaban::class, 'slug', fn ($record) => $record),

                        Forms\Components\Textarea::make('excerpt')
                            ->rows(2)
                            ->minLength(50)
                            ->maxLength(1000)
                            ->columnSpan([
                                'sm' => 2,
                            ]),

                        Forms\Components\FileUpload::make('file_ sertifikat ')
                            ->image()
                            ->maxSize(5120)
                            ->imageCropAspectRatio('16:9')
                            ->directory('blog')
                            ->columnSpan([
                                'sm' => 2,
                            ]),

                        self::getContentEditor('content'),

                        Forms\Components\BelongsToSelect::make('sertifikat_customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\BelongsToSelect::make('sertifikat_category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\DatePicker::make('published_at')
                            ->label('Published Date'),
                        SpatieTagsInput::make('tags')
                            ->required(),
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
                                ?Jawaban $record
                            ): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (
                                ?Jawaban $record
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
                Tables\Columns\ImageColumn::make('file_ sertifikat ')
                    ->rounded(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published Date')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->placeholder(fn ($state): string => 'Dec 18, '.now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('published_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
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
            'index' => Pages\ListJawabans::route('/'),
            'create' => Pages\CreateJawaban::route('/create'),
            'edit' => Pages\EditJawaban::route('/{record}/edit'),
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['customer', 'category']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'customer.name', 'category.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->customer) {
            $details['Customer'] = $record->customer->name;
        }

        if ($record->category) {
            $details['Category'] = $record->category->name;
        }

        return $details;
    }
}
