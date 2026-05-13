<?php

namespace App\Filament\Resources\ApplicationServices\Pages;

use App\Filament\Resources\ApplicationServices\ApplicationServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicationService extends CreateRecord
{
    protected static string $resource = ApplicationServiceResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
