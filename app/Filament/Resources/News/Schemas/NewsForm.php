<?php

namespace App\Filament\Resources\News\Schemas;

use App\Models\Categories;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn($state, callable $set) =>
                            $set('slug', Str::slug($state))
                        ),
                    TextInput::make('slug')
                        ->readOnly()
                        ->required()
                        ->unique(ignoreRecord: true),
                    Textarea::make('excerpt'),
                    RichEditor::make('content')
                        ->required()
                        ->fileAttachmentsDirectory('attachments')->fileAttachmentsDisk('public'),

                ])->columnSpan(2)->columns(1),

                Grid::make(1)
                    ->schema([

                        Section::make()
                            ->schema([

                                Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                Select::make('category_id')
                                    ->relationship(
                                        'categories',
                                        'name',
                                    )
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                    ])
                                    ->createOptionUsing(function ($data) {
                                        return Categories::create([
                                            'name' => $data['name'],
                                            'slug' => Str::slug($data['name']),
                                        ])->id;
                                    }),
                                FileUpload::make('featured_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('news')
                                    ->imagePreviewHeight('200'),

                                TagsInput::make('tags')
                                    ->placeholder('Separate tags with Enter or Tab')
                                    ->dehydrated(false),

                                Toggle::make('is_favorite')
                                    ->label('Jadikan Favorit')
                                    ->default(false)
                            ]),

                    ])->columnSpan(1),

            ])->columns(3);
    }
}
