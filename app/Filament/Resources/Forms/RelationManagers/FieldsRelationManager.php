<?php

namespace App\Filament\Resources\Forms\RelationManagers;

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

class FieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'fields';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Field identifier (no spaces, lowercase)'),
                \Filament\Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'text' => 'Text',
                        'email' => 'Email',
                        'number' => 'Number',
                        'tel' => 'Phone',
                        'textarea' => 'Textarea',
                        'select' => 'Select',
                        'radio' => 'Radio',
                        'checkbox' => 'Checkbox',
                        'file' => 'File Upload',
                        'date' => 'Date',
                    ]),
                \Filament\Forms\Components\Textarea::make('options')
                    ->helperText('For select/radio/checkbox, enter options as JSON: ["Option 1", "Option 2"]')
                    ->visible(fn ($get) => in_array($get('type'), ['select', 'radio', 'checkbox'])),
                TextInput::make('placeholder')
                    ->maxLength(255),
                TextInput::make('help_text')
                    ->maxLength(255),
                \Filament\Forms\Components\Toggle::make('is_required')
                    ->default(false),
                TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('label')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge(),
                \Filament\Tables\Columns\IconColumn::make('is_required')
                    ->boolean(),
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
