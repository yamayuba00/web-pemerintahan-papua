<?php

namespace App\Filament\Resources\Complaints\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->withCount('complaintLinks');
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('complaint_links_count')
                ->badge()
                ->label('Complaints Link'),
                TextColumn::make('created_at')

                    ->dateTime(
                        format: 'd M Y H:i',
                    ),
            ])
            ->filters([
                
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
