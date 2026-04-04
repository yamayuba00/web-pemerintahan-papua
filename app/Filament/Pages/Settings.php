<?php

namespace App\Filament\Pages;

use App\Models\Settings as ModelsSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use Filament\Schemas\Components\Section;


class Settings extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    protected static string|UnitEnum|null $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 999;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;

    protected string $view = 'filament.pages.settings';

    public ?array $data = [];


    public function mount(): void
    {
        $this->form->fill([
            'welcome_text' => ModelsSettings::get('welcome_text'),
            'site_name' => ModelsSettings::get('site_name'),
            'description' => ModelsSettings::get('description'),
            'logo' => ModelsSettings::get('logo'),
            'visi' => ModelsSettings::get('visi'),
            'misi' => ModelsSettings::get('misi'),

            'gubernur_nama' => ModelsSettings::get('name_gubernur'),
            'gubernur_jabatan' => ModelsSettings::get('position_gubernur'),
            'gubernur_foto' => ModelsSettings::get('photo_gubernur'),

            'wagub_nama' => ModelsSettings::get('name_wakil_gubernur'),
            'wagub_jabatan' => ModelsSettings::get('position_wakil_gubernur'),
            'wagub_foto' => ModelsSettings::get('photo_wakil_gubernur'),

            'address' => ModelsSettings::get('address'),
            'phone' => ModelsSettings::get('phone'),
            'email' => ModelsSettings::get('email'),

        ]);
    }

    // 🔥 FORM SCHEMA
    protected function getFormSchema(): array
    {
        return [

            Section::make('Page Web')
                ->schema([
                    Forms\Components\TextInput::make('site_name')
                        ->label('Nama Website')
                        ->required(),
                    Textarea::make('welcome_text')
                        ->label('Welcome Text')
                        ->required(),
                    Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->disk('public')
                        ->directory('settings'),

                    RichEditor::make('description')
                ]),

            Section::make('Visi & Misi')
                ->schema([
                    RichEditor::make('visi')
                        ->required(),
                    RichEditor::make('misi')
                        ->required(),
                ]),

            Section::make('Gubernur')
                ->schema([
                    Forms\Components\FileUpload::make('gubernur_foto')
                        ->image()
                        ->disk('public')
                        ->directory('settings'),

                    Forms\Components\TextInput::make('gubernur_nama'),

                    Forms\Components\TextInput::make('gubernur_jabatan')
                        ->default('Gubernur'),
                ])
                ->columns(2),

            Section::make('Wakil Gubernur')
                ->schema([
                    Forms\Components\FileUpload::make('wagub_foto')
                        ->image()
                        ->disk('public')
                        ->directory('settings'),

                    Forms\Components\TextInput::make('wagub_nama'),

                    Forms\Components\TextInput::make('wagub_jabatan')
                        ->default('Wakil Gubernur'),
                ])
                ->columns(2),
            Section::make('Contact')
                ->schema([
                    Forms\Components\TextInput::make('address')
                        // format address
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->prefix('+62')
                        ->placeholder('8123456789')
                        ->dehydrateStateUsing(fn($state) => $state ? '+62' . ltrim($state, '0') : null)
                        ->mask(fn($mask) => $mask?->pattern('0000-0000-0000'))
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->columns(2),
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function save(): void
    {
        $data = $this->form->getState();

        ModelsSettings::set('site_name', $data['site_name']);
        ModelsSettings::set('welcome_text', $data['welcome_text']);
        ModelsSettings::set('logo', $data['logo']);
        ModelsSettings::set('description', $data['description']);

        ModelsSettings::set('visi', $data['visi']);
        ModelsSettings::set('misi', $data['misi']);

        ModelsSettings::set('name_gubernur', $data['gubernur_nama']);
        ModelsSettings::set('position_gubernur', $data['gubernur_jabatan']);
        ModelsSettings::set('photo_gubernur', $data['gubernur_foto']);

        ModelsSettings::set('name_wakil_gubernur', $data['wagub_nama']);
        ModelsSettings::set('position_wakil_gubernur', $data['wagub_jabatan']);
        ModelsSettings::set('photo_wakil_gubernur', $data['wagub_foto']);

        ModelsSettings::set('address', $data['address']);
        ModelsSettings::set('phone', $data['phone']);
        ModelsSettings::set('email', $data['email']);

        Notification::make()
            ->title('Berhasil')
            ->body('Settings sucessfully updated!')
            ->success()
            ->send();
    }
}
