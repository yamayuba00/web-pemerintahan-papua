<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Add News')
            ->createAnother(false),
        ];
    }

    public function getTabs() : array {
        return [
            'All' => Tab::make(),
            'Published' =>Tab::make()->modifyQueryUsing(function (Builder $query) {
                return $query->where('status', 'published');
            }),
            'Archived' => Tab::make()->modifyQueryUsing(function (Builder $query) {
                return $query->where('status', 'archived');
            }),
            'Draft' => Tab::make()->modifyQueryUsing(function (Builder $query) {
                return $query->where('status', 'draft');
            }),
        ];
    }
}
