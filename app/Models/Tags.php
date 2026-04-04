<?php

namespace App\Models;

use App\Models\Article;
use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $guarded = [];
    protected $table = 'tags';

    public function news()
    {
        return $this->morphedByMany(
            News::class,
            'taggable',
            'taggables',
            'tags_id',
            'taggable_id'
        );
    }

    // relasi ke Article
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }
}
