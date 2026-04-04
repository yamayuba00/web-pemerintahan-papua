<?php

namespace App\Filament\Resources\NewsCategories\Pages;

use App\Filament\Resources\NewsCategories\NewsCategoriesResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;

class ListNewsCategories extends ListRecords
{
    protected static string $resource = NewsCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Category')
                ->createAnother(false)
                ->modalWidth('3xl')
                ->modalHeading('Add Category'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Category')
                ->modalWidth('3xl')
                ->modalHeading('Edit Category'),

            DeleteAction::make()
                ->modalHeading('Delete Category')
                ->modalSubmitActionLabel('Hapus')
        ];
    }
}
