<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    protected $guarded = [];

    protected $appends = ['image_url'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    protected static function booted()
    {
        static::deleting(function ($slider) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
        });
    }
}
