<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-photo';
    
    protected static ?string $navigationLabel = 'Portfolio Projects';
    
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Slug')
                    ->helperText('URL-friendly identifier (e.g., master-bedroom)'),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->label('Display Order'),
                
                Forms\Components\Toggle::make('featured')
                    ->label('Featured Project'),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'published' => 'Published',
                        'draft' => 'Draft',
                        'private' => 'Private',
                    ])
                    ->default('published')
                    ->required(),
                
                Forms\Components\Select::make('categories')
                    ->multiple()
                    ->options([
                        'bedroom' => 'Bedroom',
                        'living-room' => 'Living Room',
                        'dining' => 'Dining',
                        'kitchen' => 'Kitchen',
                        'bathroom' => 'Bathroom',
                        'entertainment' => 'Entertainment',
                        'office' => 'Office',
                        'kids' => 'Kids & Play',
                        'entrance' => 'Entrance & Corridors',
                        'staircase' => 'Staircase',
                        'other' => 'Other',
                    ]),
                
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('description_en')
                    ->label('Description (English)')
                    ->required()
                    ->rows(3),
                
                Forms\Components\TextInput::make('title_ar')
                    ->label('Title (Arabic)')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('description_ar')
                    ->label('Description (Arabic)')
                    ->required()
                    ->rows(3),
                
                SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->collection('thumbnail')
                    ->image()
                    ->maxSize(5120)
                    ->deletable()
                    ->downloadable()
                    ->label('Thumbnail Image'),
                
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->multiple()
                    ->reorderable()
                    ->image()
                    ->maxSize(10240)
                    ->deletable()
                    ->downloadable()
                    ->label('Gallery Images'),
                
                Forms\Components\TagsInput::make('tags')
                    ->label('Tags'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('thumbnail')
                    ->conversion('thumb')
                    ->size(60),
                
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('image_count')
                    ->label('Images')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-photo'),
                
                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                        'danger' => 'private',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'published' => 'Published',
                        'draft' => 'Draft',
                        'private' => 'Private',
                    ]),
                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Featured Projects'),
            ])
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
