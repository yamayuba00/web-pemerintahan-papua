<?php

namespace App\Filament\Resources\Tourisms\Pages;

use App\Filament\Resources\Tourisms\TourismResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListTourisms extends ListRecords
{
    protected static string $resource = TourismResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Tourism')
                ->createAnother(false),
        ];
    }
}
