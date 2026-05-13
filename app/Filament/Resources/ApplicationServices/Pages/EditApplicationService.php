<?php

namespace App\Filament\Resources\ApplicationServices\Pages;

use App\Filament\Resources\ApplicationServices\ApplicationServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationService extends EditRecord
{
    protected static string $resource = ApplicationServiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
