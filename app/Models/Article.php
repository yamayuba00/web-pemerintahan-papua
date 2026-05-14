<?php

namespace App\Models;

use App\Models\Categories;
use App\Models\Tags;
use App\Models\Traits\HasSeo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    protected $guarded = [];

    use HasSeo;

    protected $appends = ['featured_image_url'];

    public function tags()
    {
        return $this->morphToMany(Tags::class, 'taggable', 'taggables', 'taggable_id', 'tag_id');
    }
    public function categories()
    {
        return $this->morphToMany(Categories::class, 'categoryable', 'categoryables', 'categoryable_id', 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // SEO Configuration
    public function getSeoMetaDescription()
    {
        return strip_tags($this->content);
    }
    
    public function getSeoSchemaType()
    {
        return 'Article';
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

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }
}
