<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('meta_description')
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('SEO meta description')
                    ->columnSpanFull(),
                TextInput::make('meta_keywords')
                    ->maxLength(255)
                    ->helperText('Comma-separated keywords for SEO'),
                Select::make('form_id')
                    ->relationship('form', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('Optional: Attach a form to this page'),
                Toggle::make('is_published')
                    ->default(false)
                    ->helperText('Publish this page to make it visible'),
            ]);
    }
}
