<?php

namespace App\Filament\Resources\Languages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LanguageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('locale')
                    ->label('Locale')
                    ->placeholder('Ej: en, es_ES')
                    ->maxLength(10),
                TextInput::make('flag')
                    ->label('Flag')
                    ->placeholder('Ej: us.png')
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}