<?php

namespace App\Filament\Resources\ApplicationServices\Pages;

use App\Filament\Resources\ApplicationServices\ApplicationServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListApplicationServices extends ListRecords
{
    protected static string $resource = ApplicationServiceResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Application Service')
                ->createAnother(false),
        ];
    }
}
