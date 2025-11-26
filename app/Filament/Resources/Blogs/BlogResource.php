<?php

namespace App\Filament\Resources\Blogs;

use App\Filament\Resources\Blogs\Pages\CreateBlog;
use App\Filament\Resources\Blogs\Pages\EditBlog;
use App\Filament\Resources\Blogs\Pages\ListBlogs;
use App\Filament\Resources\Blogs\Schemas\BlogForm;
use App\Filament\Resources\Blogs\Tables\BlogsTable;
use App\Models\Blog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;


class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Blogs';
    protected static ?string $pluralLabel = 'Blogs';
    protected static ?string $modelLabel = 'Blog';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title_en')
                    ->label('Title EN')
                    ->required()
                    ->maxLength(255),
                TextInput::make('title_ar')
                    ->label('Title AR')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description_en')
                    ->label('Description EN')
                    ->required()
                    ->rows(5),
                Textarea::make('description_ar')
                    ->label('Description AR')
                    ->required()
                    ->rows(5),
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('blogs')
                    ->disk('public')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title_en')->sortable()->searchable(),
                TextColumn::make('title_ar')->sortable()->searchable(),
                TextColumn::make('description_en')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('description_ar')
                    ->limit(50)
                    ->wrap(),
                ImageColumn::make('image')->disk('public'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
