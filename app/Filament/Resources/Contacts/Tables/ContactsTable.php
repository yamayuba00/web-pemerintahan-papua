<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Models\Contact;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn (Contact $record) => $record->is_read ? null : 'bold'),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('message')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make()->iconButton(),
                Action::make('is_read')
                    ->icon(fn (Contact $record) => $record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-envelope-open')
                    ->label(fn (Contact $record) => $record->is_read ? 'Mark Unread' : 'Mark Read')
                    ->action(fn (Contact $record) => $record->update(['is_read' => !$record->is_read]))
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
