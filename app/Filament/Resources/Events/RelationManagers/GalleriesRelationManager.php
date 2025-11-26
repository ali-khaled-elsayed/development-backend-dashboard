<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Models\Gallery;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;


class GalleriesRelationManager extends RelationManager
{
    protected static string $relationship = 'galleries';

    protected static ?string $title = 'Gallery';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('url')
                    ->label('Media')
                    ->multiple()
                    ->disk('public')
                    ->directory('galleries')
                    ->maxSize(102400)
                    ->required()
                    ->acceptedFileTypes(['image/*', 'video/mp4'])
                    ->previewable(true),

            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('url')
                    ->label('Preview')
                    ->view('media-preview')
                    ->extraAttributes(['class' => 'flex justify-center']),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->colors([
                        'primary' => 'image',
                        'warning' => 'video',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->using(function ($record, array $data, RelationManager $livewire) {

                        $parent = $livewire->ownerRecord;

                        foreach ($data['url'] as $filePath) {

                            $type = str_ends_with($filePath, '.mp4') ? 'video' : 'image';

                            $parent->galleries()->create([
                                'url'  => $filePath,
                                'type' => $type,
                            ]);
                        }

                        return null;
                    }),
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
