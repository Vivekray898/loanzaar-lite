<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'hero' => 'Hero',
                        'benefits' => 'Benefits',
                        'features' => 'Features',
                        'faq' => 'FAQ',
                        'testimonials' => 'Testimonials',
                        'cta' => 'Call to Action',
                    ]),
                TextInput::make('title')
                    ->maxLength(255),
                \Filament\Forms\Components\Textarea::make('content')
                    ->rows(5)
                    ->helperText('JSON content for the section')
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('order')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
