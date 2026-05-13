<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tourism extends Model
{
    protected $table = 'tourisms';

    protected $fillable = [
        'name',
        'slug',
        'location',
        'description',
        'image',
        'category',
    ];

    protected static function booted(): void
    {
        static::creating(function (Tourism $tourism) {
            if (empty($tourism->slug)) {
                $tourism->slug = Str::slug($tourism->name);
            }
        });
    }
}
