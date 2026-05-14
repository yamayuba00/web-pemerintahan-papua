<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Unread' => Tab::make()->modifyQueryUsing(function (Builder $query) {
                return $query->where('is_read', false);
            }),
            'Read' => Tab::make()->modifyQueryUsing(function (Builder $query) {
                return $query->where('is_read', true);
            }),
        ];
    }
}
