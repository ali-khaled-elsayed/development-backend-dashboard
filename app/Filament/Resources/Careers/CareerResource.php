<?php

namespace App\Filament\Resources\Careers;

use App\Filament\Resources\Careers\Pages\CreateCareer;
use App\Filament\Resources\Careers\Pages\EditCareer;
use App\Filament\Resources\Careers\Pages\ListCareers;
use App\Filament\Resources\Careers\Schemas\CareerForm;
use App\Filament\Resources\Careers\Tables\CareersTable;
use App\Models\Careers;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class CareerResource extends Resource
{
    protected static ?string $model = Careers::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Careers';
    protected static ?string $pluralLabel = 'Careers';
    protected static ?string $modelLabel = 'Career';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('title_en')
                ->label('Title (EN)')
                ->required()
                ->maxLength(255),

            TextInput::make('title_ar')
                ->label('Title (AR)')
                ->required()
                ->maxLength(255),

            Textarea::make('description_en')
                ->label('Description (EN)')
                ->required()
                ->rows(4),

            Textarea::make('description_ar')
                ->label('Description (AR)')
                ->required()
                ->rows(4),

            Select::make('type')
                ->label('Career Type')
                ->options([
                    'full_time' => 'Full Time',
                    'part_time' => 'Part Time'
                ])
                ->required(),

            FileUpload::make('image')
                ->label('Career Image')
                ->image()
                ->directory('careers')
                ->disk('public')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->disk('public')->label('Image'),

                TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => ListCareers::route('/'),
            'create' => CreateCareer::route('/create'),
            'edit' => EditCareer::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
