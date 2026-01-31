<?php

namespace App\Filament\Resources\Forms\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->default(true),
                Textarea::make('thank_you_message')
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('Message shown after form submission'),
                TextInput::make('redirect_url')
                    ->url()
                    ->maxLength(255)
                    ->helperText('Optional: Redirect to this URL after submission'),
            ]);
    }
}
