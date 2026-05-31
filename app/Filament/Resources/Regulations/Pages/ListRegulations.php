<?php

namespace App\Filament\Resources\Regulations\Pages;

use App\Filament\Resources\Regulations\RegulationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListRegulations extends ListRecords
{
    protected static string $resource = RegulationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Data')
                ->createAnother(false),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make(),
            'Regulasi' => Tab::make()->modifyQueryUsing(
                fn (Builder $query) => $query->where('type', 'regulasi')
            ),
            'Publikasi Data' => Tab::make()->modifyQueryUsing(
                fn (Builder $query) => $query->where('type', 'publikasi')
            ),
        ];
    }
}
