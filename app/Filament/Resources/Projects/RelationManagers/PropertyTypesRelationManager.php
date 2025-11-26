<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\PropertyType;
use App\Modules\Shared\Enums\UnitTypeEnum;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Tables;
use Filament\Resources\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Grid;

class PropertyTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'propertyTypes';

    protected static ?string $title = 'Units';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->directory('image')
                        ->nullable(),

                    Forms\Components\Select::make('type')
                        ->label('Type')
                        ->options(UnitTypeEnum::options())
                        ->required(),
                ]),

                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('price_min')
                        ->numeric()
                        ->label('Price Min')
                        ->nullable(),

                    Forms\Components\TextInput::make('price_max')
                        ->numeric()
                        ->label('Price Max')
                        ->nullable(),
                ]),

                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('area_min')
                        ->numeric()
                        ->label('Area Min')
                        ->nullable(),

                    Forms\Components\TextInput::make('area_max')
                        ->numeric()
                        ->label('Area Max')
                        ->nullable(),
                ]),

                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('no_of_bedrooms_min')
                        ->numeric()
                        ->label('Bedrooms Min')
                        ->nullable(),

                    Forms\Components\TextInput::make('no_of_bedrooms_max')
                        ->numeric()
                        ->label('Bedrooms Max')
                        ->nullable(),
                ]),

                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('no_of_bathrooms_min')
                        ->numeric()
                        ->label('Bathrooms Min')
                        ->nullable(),

                    Forms\Components\TextInput::make('no_of_bathrooms_max')
                        ->numeric()
                        ->label('Bathrooms Max')
                        ->nullable(),
                ]),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('Type')->searchable(),
                Tables\Columns\TextColumn::make('area_min')->label('Area Min'),
                Tables\Columns\TextColumn::make('area_max')->label('Area Max'),
                Tables\Columns\TextColumn::make('price_min')->label('Price Min'),
                Tables\Columns\TextColumn::make('price_max')->label('Price Max'),
                Tables\Columns\TextColumn::make('no_of_bedrooms_min')->label('Bed Min'),
                Tables\Columns\TextColumn::make('no_of_bedrooms_max')->label('Bed Max'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
