<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use App\Models\Tags;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['tags'] = $this->record->tags
            ? $this->record->tags->pluck('name')->toArray()
            : [];

        return $data;
    }

    /**
     * 🔥 HANDLE IMAGE SEBELUM SAVE (ANTI NUMPUK)
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $disk = Storage::disk('public');

        $oldImage = $this->record?->featured_image;
        $newImage = $data['featured_image'] ?? null;

        // kalau tidak berubah
        if ($oldImage === $newImage) {
            return $data;
        }

        // kalau ada file baru
        if ($newImage && $disk->exists($newImage)) {

            $webpPath = $this->convertToWebp($newImage);

            if ($webpPath) {

                // hapus file lama
                if ($oldImage && $disk->exists($oldImage)) {
                    $disk->delete($oldImage);
                }

                // pakai hasil webp
                $data['featured_image'] = $webpPath;
            }
        }

        return $data;
    }

    /**
     * 🔥 HANDLE TAGS SETELAH SAVE
     */
    protected function afterSave(): void
    {
        $tags = collect($this->data['tags'] ?? [])
            ->map(fn($tag) => strtolower(trim($tag)))
            ->filter()
            ->unique();

        $tagIds = $tags->map(fn($tag) => Tags::firstOrCreate(
            ['slug' => Str::slug($tag)],
            ['name' => $tag]
        )->id);

        $this->record->tags()->sync($tagIds);
    }

    /**
     * 🔥 CONVERT IMAGE KE WEBP (NO DUPLICATE)
     */
    private function convertToWebp(string $filePath): ?string
    {
        $disk = Storage::disk('public');
        $fullPath = $disk->path($filePath);

        $info = @getimagesize($fullPath);

        if (!$info || !isset($info['mime'])) {
            return null;
        }

        switch ($info['mime']) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($fullPath);
                break;

            case 'image/png':
                $img = imagecreatefrompng($fullPath);
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                break;

            case 'image/webp':
                $img = imagecreatefromwebp($fullPath);
                break;

            default:
                return null;
        }

        $newWidth = 1200;
        $newHeight = 630;

        $tmp = imagecreatetruecolor($newWidth, $newHeight);

        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);

        imagecopyresampled(
            $tmp,
            $img,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            imagesx($img),
            imagesy($img)
        );

        // 🔥 simpan ke folder FIX (biar gak numpuk random)
        $newPath = 'news/' . Str::uuid() . '.webp';

        imagewebp($tmp, $disk->path($newPath), 75);

        // 🔥 hapus file upload asli (temp dari filament)
        if ($disk->exists($filePath)) {
            $disk->delete($filePath);
        }

        unset($img);
        unset($tmp);

        return $newPath;
    }
}
