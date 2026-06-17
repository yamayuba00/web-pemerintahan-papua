<?php

namespace App\Filament\Resources\Tourisms\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class TourismForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true),
                    TextInput::make('location')
                        ->maxLength(255)
                        ->nullable(),

                    TextInput::make('category')
                        ->maxLength(255)
                        ->nullable()
                        ->hiddenOn('create'),

                    RichEditor::make('description')
                        ->fileAttachmentsDirectory('attachments')
                        ->fileAttachmentsDisk('public')
                        ->nullable(),

                    FileUpload::make('image')
                        ->image()
                        ->disk('public')
                        ->directory('tourism')
                        ->imagePreviewHeight('200')
                        ->nullable(),

                    Toggle::make('is_favorite')
                        ->label('Jadikan Favorit')
                        ->default(false),
                ])->columns(1),
            ])->columns(1);
    }
}
