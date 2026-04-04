<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use App\Models\Tags;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $tagsInput = $this->data['tags'] ?? [];

        if (empty($tagsInput)) {
            return;
        }

        $tagIds = collect($tagsInput)
            ->map(function ($tag) {
                $tag = strtolower(trim($tag));

                return Tags::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($tag)],
                    ['name' => $tag]
                )->id;
            });

        $this->record->tags()->sync($tagIds);


        if (
            $this->record->featured_image &&
            Storage::disk('public')->exists($this->record->featured_image)
        ) {
            $this->convertToWebp($this->record->featured_image);
        }
    }

    private function convertToWebp(string $filePath): void
    {
        $disk = Storage::disk('public');
        $fullPath = $disk->path($filePath);

        $info = @getimagesize($fullPath);
        if (!$info || !isset($info['mime'])) {
            return;
        }

        switch ($info['mime']) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($fullPath);
                break;

            case 'image/png':
                $img = imagecreatefrompng($fullPath);

                // handle transparency
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                break;

            case 'image/webp':
                $img = imagecreatefromwebp($fullPath);
                break;

            default:
                return;
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

        $newFileName = pathinfo($filePath, PATHINFO_FILENAME) . '-' . time() . '.webp';
        $newPath = dirname($filePath) . '/' . $newFileName;

        $result = imagewebp($tmp, $disk->path($newPath), 75);

        if (!$result) {
            unlink($img);
            unlink($tmp);
            return;
        }

        if ($disk->exists($filePath)) {
            $disk->delete($filePath);
        }

        $this->record->forceFill([
            'featured_image' => $newPath
        ])->saveQuietly();

        unset($img);
        unset($tmp);
    }
}
