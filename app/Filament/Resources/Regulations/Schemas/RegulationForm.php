<?php

namespace App\Filament\Resources\Regulations\Schemas;

use Filament\Forms\Components\FileUpload;
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
                        ->label('Link (opsional)')
                        ->url()
                        ->nullable()
                        ->placeholder('https://example.com/dokumen.pdf')
                        ->helperText('Isi link jika dokumen berasal dari URL external.'),

                    FileUpload::make('document')
                        ->label('Upload Dokumen (opsional)')
                        ->disk('public')
                        ->directory('regulations')
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(5120) // 5MB
                        ->helperText('Maks 5MB. Format: PDF, DOC, DOCX.'),
                ])->columns(1),
            ]);
    }
}
