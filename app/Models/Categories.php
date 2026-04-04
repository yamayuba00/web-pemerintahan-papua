<?php

namespace App\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categories extends Model
{
    protected $guarded = [];

    protected $table = 'categories';

    public function news()
    {
        return $this->hasMany(News::class, 'category_id');
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    // auto slug
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
