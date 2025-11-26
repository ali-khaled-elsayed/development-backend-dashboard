<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $title = 'Services';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\CheckboxList::make('services')
                    ->relationship('services', 'name_en')
                    ->columns(2)
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->recordTitleAttribute('name_en')
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name EN')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name_ar')
                    ->label('Name AR')
                    ->searchable(),
            ])
            ->headerActions([
                Action::make('attach_services')
                    ->label('Attach Services')
                    ->form([
                        Forms\Components\CheckboxList::make('services')
                            ->label('Select Services')
                            ->options(Service::pluck('name_en', 'id'))
                            ->columns(2)
                            ->required(),
                    ])
                    ->action(function ($data, $livewire) {
                        $record = $livewire->getOwnerRecord(); // parent model

                        // Attach many-to-many or insert pivot manually
                        $record->services()->syncWithoutDetaching($data['services']);
                    })
            ])
            ->actions([
                DetachAction::make(),
            ])
            ->bulkActions([
                DetachBulkAction::make(),
            ]);
    }
}
