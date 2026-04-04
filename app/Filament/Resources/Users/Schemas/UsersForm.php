<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Resources\Users\Pages\CreateUsers;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->live(onBlur: true),
                TextInput::make('password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof CreateUsers)
                    ->dehydrated(fn($state) => filled($state)),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof CreateUsers)
                    ->dehydrated(false)
                    ->same('password'),
                Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload(),
            ]);
    }
}
