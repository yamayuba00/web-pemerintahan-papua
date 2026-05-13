<?php

namespace App\Filament\Resources\ApplicationServices\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class ApplicationServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('url')
                        ->url()
                        ->maxLength(255)
                        ->nullable()
                        ->placeholder('https://example.com'),

                    Textarea::make('description')
                        ->rows(5)
                        ->nullable(),
                ])->columns(1),
            ])->columns(1);
    }
}
