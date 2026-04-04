<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service')->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('description')
                        ->rows(3),

                    Repeater::make('complaintLinks')
                        ->relationship()
                        ->label('Link Services')
                        ->schema([
                            TextInput::make('title')
                                ->label('Name Service')
                                ->placeholder('Ex: Aduan Informasi Area'),

                            TextInput::make('url')
                                ->label('URL')
                                ->required()
                                ->url(),

                            TextInput::make('order')
                                ->numeric()
                                ->default(1),
                        ])
                        ->defaultItems(1)
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn($state) => $state['title'] ?? 'Link')
                ])->columnSpanFull(),
            ]);
    }
}
