<?php

namespace App\Filament\Resources\Leads\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StatusLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'statusLogs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('new_status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('new_status')
            ->columns([
                TextColumn::make('old_status')
                    ->label('From')
                    ->badge()
                    ->colors([
                        'gray' => 'new',
                        'warning' => 'contacted',
                        'info' => 'in_review',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('new_status')
                    ->label('To')
                    ->badge()
                    ->colors([
                        'gray' => 'new',
                        'warning' => 'contacted',
                        'info' => 'in_review',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('changedBy.name')
                    ->label('Changed By'),
                TextColumn::make('notes')
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}
