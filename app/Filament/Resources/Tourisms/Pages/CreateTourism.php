<?php

namespace App\Filament\Resources\Tourisms\Pages;

use App\Filament\Resources\Tourisms\TourismResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTourism extends CreateRecord
{
    protected static string $resource = TourismResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
