<?php

namespace App\Filament\Resources\Tourisms\Pages;

use App\Filament\Resources\Tourisms\TourismResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditTourism extends EditRecord
{
    protected static string $resource = TourismResource::class;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $disk = Storage::disk('public');

        $oldImage = $this->record?->image;
        $newImage = $data['image'] ?? null;

        // Kalau gambar tidak berubah, skip
        if ($oldImage === $newImage) {
            return $data;
        }

        // Hapus gambar lama kalau ada file baru
        if ($newImage && $oldImage && $disk->exists($oldImage)) {
            $disk->delete($oldImage);
        }

        return $data;
    }
}
