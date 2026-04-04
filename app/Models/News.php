<?php

namespace App\Models;

use App\Models\Categories;
use App\Models\User;
use App\Models\Tags;
use App\Models\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class News extends Model
{
    use HasSeo;
    protected $guarded = [];

    public function categories()
    {
        return $this->morphToMany(Categories::class, 'categoryable', 'categoryables', 'categoryable_id', 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tags()
    {
        return $this->morphToMany(Tags::class, 'taggable', 'taggables', 'taggable_id', 'tag_id');
    }
    // relasi ke Article
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    // SEO Configuration
    public function getSeoMetaDescription()
    {
        return strip_tags($this->content);
    }
   
    public function getSeoSchemaType()
    {
        return 'News';
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->status == 'published') {
                $model->published_at = now();
            }
            $model->created_by = Auth::user()->id;
        });
    }
}
