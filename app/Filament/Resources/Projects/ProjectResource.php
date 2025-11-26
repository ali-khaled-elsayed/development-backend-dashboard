<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\RelationManagers\GalleriesRelationManager;
use App\Filament\Resources\Projects\RelationManagers\PropertyTypesRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ServicesRelationManager;
use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Filament\Resources\Projects\Tables\ProjectsTable;
use App\Models\Area;
use App\Models\City;
use App\Models\Project;
use App\Modules\Project\Enums\ProjectTypeEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section;


class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Projects';
    protected static ?string $pluralLabel = 'Projects';
    protected static ?string $modelLabel = 'Project';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Basic Info')
                ->schema([
                    TextInput::make('title_en')->required(),
                    TextInput::make('title_ar')->required(),

                    Textarea::make('short_description_en'),
                    Textarea::make('short_description_ar'),

                    Textarea::make('description_en'),
                    Textarea::make('description_ar'),
                ])
                ->columns(2),

            Section::make('Project Details')
                ->schema([
                    TextInput::make('project_area')->numeric(),
                    Select::make('type')
                        ->label('Project Type')
                        ->options(ProjectTypeEnum::options())
                        ->required(),
                    DatePicker::make('delivery_date'),
                    KeyValue::make('payment_plan')
                        ->keyLabel('percentage')
                        ->valueLabel('Description')
                        ->addButtonLabel('Add Step'),

                    Select::make('city_id')
                        ->options(City::all()->pluck('name_en', 'id'))
                        ->reactive()
                        ->required(),

                    Select::make('area_id')
                        ->reactive()
                        ->options(function (callable $get) {
                            $cityId = $get('city_id');
                            if (!$cityId) {
                                return [];
                            }
                            return Area::where('city_id', $cityId)->pluck('name_en', 'id');
                        })
                        ->searchable()
                        ->required(),
                ])
                ->columns(2),

            Section::make('Meta Data')
                ->schema([
                    TextInput::make('meta_title_en'),
                    TextInput::make('meta_title_ar'),
                    Textarea::make('meta_description_en'),
                    Textarea::make('meta_description_ar'),
                ])
                ->columns(2),

            Section::make('Media')
                ->schema([
                    FileUpload::make('logo')
                        ->image()
                        ->directory('projects/logos'),

                    FileUpload::make('master_plan')
                        ->image()
                        ->directory('projects/master_plans'),

                    TextInput::make('video_link'),

                ])
                ->columns(2),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title_en')->searchable()->sortable(),
            TextColumn::make('city.name_en')->label('City')->sortable(),
            TextColumn::make('area.name_en')->label('Area')->sortable(),
            TextColumn::make('type'),
            TextColumn::make('delivery_date')->date(),
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
            PropertyTypesRelationManager::class,
            ServicesRelationManager::class,
            GalleriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
