<?php

namespace App\Filament\Resources\Sliders\Pages;

use App\Filament\Resources\Sliders\SliderResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateSlider extends CreateRecord
{
    protected static string $resource = SliderResource::class;

    protected function afterCreate(): void
    {
        if (
            $this->record->image &&
            Storage::disk('public')->exists($this->record->image)
        ) {
            $this->convertToWebp($this->record->image);
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
            'image' => $newPath
        ])->saveQuietly();

        unset($img);
        unset($tmp);
    }
}
