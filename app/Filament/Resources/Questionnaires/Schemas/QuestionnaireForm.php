<?php

namespace App\Filament\Resources\Questionnaires\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class QuestionnaireForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kuesioner')
                    ->description('Atur judul, deskripsi, dan status kuesioner.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Kuesioner')
                            ->placeholder('Contoh: Survei Kepuasan Layanan 2026')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, callable $set) =>
                                $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->readOnly()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Otomatis dari judul. Digunakan sebagai URL kuesioner.'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Jelaskan tujuan kuesioner ini...')
                            ->rows(3)
                            ->nullable()
                            ->helperText('Akan ditampilkan di halaman kuesioner sebelum responden mengisi.'),

                        Toggle::make('is_active')
                            ->label('Kuesioner Aktif')
                            ->helperText('Jika nonaktif, kuesioner tidak bisa diakses oleh responden.')
                            ->default(true),

                        Select::make('scoring_type')
                            ->label('Metode Penilaian')
                            ->options([
                                'skm' => 'SKM (Survei Kepuasan Masyarakat) - Skala 1-4',
                                'rating_5' => 'Rating Bintang - Skala 1-5',
                            ])
                            ->default('skm')
                            ->required()
                            ->helperText('SKM: skala 1-4 sesuai Permenpan RB No. 14/2017. Rating: skala 1-5 bintang.'),
                    ])->columns(1),

                Section::make('Daftar Pertanyaan')
                    ->description('Tambahkan pertanyaan untuk kuesioner. Drag untuk mengubah urutan.')
                    ->icon('heroicon-o-question-mark-circle')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship()
                            ->schema([
                                TextInput::make('question')
                                    ->label('Pertanyaan')
                                    ->placeholder('Tulis pertanyaan di sini...')
                                    ->required()
                                    ->columnSpanFull(),

                                Select::make('type')
                                    ->label('Tipe Jawaban')
                                    ->options([
                                        'text' => '📝 Free Text (Jawaban bebas)',
                                        'dropdown' => '📋 Dropdown (Pilih satu dari daftar)',
                                        'checkbox' => '☑️ Checkbox (Pilih banyak)',
                                        'radio' => '🔘 Radio (Pilih satu)',
                                        'rating' => '⭐ Rating (Skala 1-5 bintang)',
                                    ])
                                    ->required()
                                    ->reactive()
                                    ->helperText(function (callable $get) {
                                        return match ($get('type')) {
                                            'text' => 'Responden bisa menulis jawaban bebas.',
                                            'dropdown' => 'Responden memilih 1 jawaban dari dropdown.',
                                            'checkbox' => 'Responden bisa memilih lebih dari 1 jawaban.',
                                            'radio' => 'Responden memilih 1 jawaban dari pilihan.',
                                            'rating' => 'Responden memberi rating 1-5 bintang.',
                                            default => 'Pilih tipe jawaban untuk pertanyaan ini.',
                                        };
                                    }),

                                TagsInput::make('options')
                                    ->label('Opsi Jawaban')
                                    ->placeholder('Ketik opsi lalu tekan Enter')
                                    ->helperText('Tambahkan opsi jawaban satu per satu. Tekan Enter atau Tab setelah setiap opsi.')
                                    ->visible(fn (callable $get) => in_array($get('type'), ['dropdown', 'checkbox', 'radio']))
                                    ->columnSpanFull(),

                                Toggle::make('is_required')
                                    ->label('Wajib Diisi')
                                    ->helperText('Jika aktif, responden harus menjawab pertanyaan ini.')
                                    ->default(true),

                                TextInput::make('order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Angka kecil tampil lebih dulu.'),
                            ])
                            ->columns(2)
                            ->orderColumn('order')
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string =>
                                $state['question']
                                    ? ($state['question'] . ' (' . match($state['type'] ?? '') {
                                        'text' => '📝 Text',
                                        'dropdown' => '📋 Dropdown',
                                        'checkbox' => '☑️ Checkbox',
                                        'radio' => '🔘 Radio',
                                        'rating' => '⭐ Rating',
                                        default => '?',
                                    } . ')')
                                    : null
                            )
                            ->addActionLabel('+ Tambah Pertanyaan')
                            ->defaultItems(0),
                    ])->columns(1),
            ]);
    }
}
