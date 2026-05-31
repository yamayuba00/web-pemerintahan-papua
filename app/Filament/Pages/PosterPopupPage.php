<?php

namespace App\Filament\Pages;

use App\Models\PosterPopup;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class PosterPopupPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|UnitEnum|null $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 998;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;
    protected static ?string $navigationLabel = 'Poster Popup';
    protected static ?string $title = 'Poster Popup';

    protected string $view = 'filament.pages.poster-popup';

    public ?array $data = [];

    public function mount(): void
    {
        $poster = PosterPopup::first();

        $this->form->fill([
            'image' => $poster?->image,
            'link' => $poster?->link,
            'is_active' => $poster?->is_active ?? true,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Poster Popup')
                ->description('Gambar popup yang muncul saat website dibuka. Hanya bisa 1 poster.')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Poster')
                        ->image()
                        ->disk('public')
                        ->directory('posters')
                        ->imagePreviewHeight('300')
                        ->required(),

                    Forms\Components\TextInput::make('link')
                        ->label('Link (opsional)')
                        ->url()
                        ->placeholder('https://example.com')
                        ->helperText('URL tujuan ketika poster diklik.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktifkan Popup')
                        ->helperText('Jika nonaktif, popup tidak akan muncul di website.')
                        ->default(true),
                ]),
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $poster = PosterPopup::first();

        // Hapus gambar lama jika diganti
        if ($poster && $poster->image && $poster->image !== $data['image']) {
            if (Storage::disk('public')->exists($poster->image)) {
                Storage::disk('public')->delete($poster->image);
            }
        }

        if ($poster) {
            $poster->update($data);
        } else {
            PosterPopup::create($data);
        }

        Notification::make()
            ->title('Berhasil')
            ->body('Poster popup berhasil disimpan!')
            ->success()
            ->send();
    }
}
