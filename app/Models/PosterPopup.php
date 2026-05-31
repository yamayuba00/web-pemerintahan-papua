<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PosterPopup extends Model
{
    protected $table = 'poster_popups';

    protected $fillable = [
        'image',
        'link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    protected static function booted()
    {
        static::deleting(function ($poster) {
            if ($poster->image) {
                Storage::disk('public')->delete($poster->image);
            }
        });
    }
}
