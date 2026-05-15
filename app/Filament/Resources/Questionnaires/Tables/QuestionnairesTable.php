<?php

namespace App\Filament\Resources\Questionnaires\Tables;

use App\Filament\Resources\Questionnaires\QuestionnaireResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestionnairesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Pertanyaan'),
                TextColumn::make('responses_count')
                    ->counts('responses')
                    ->label('Responden'),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                Action::make('responses')
                    ->label('Lihat Hasil')
                    ->icon('heroicon-o-chart-bar')
                    ->url(fn ($record) => QuestionnaireResource::getUrl('responses', ['record' => $record]))
                    ->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
