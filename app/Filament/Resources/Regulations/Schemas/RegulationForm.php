<?php

namespace App\Filament\Resources\Regulations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegulationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Select::make('type')
                        ->label('Jenis')
                        ->options([
                            'regulasi' => 'Regulasi',
                            'publikasi' => 'Publikasi Data',
                        ])
                        ->default('regulasi')
                        ->required(),

                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('link')
                        ->label('Link')
                        ->url()
                        ->required()
                        ->placeholder('https://example.com/dokumen.pdf'),
                ])->columns(1),
            ]);
    }
}
