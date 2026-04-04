<?php

namespace App\Models\Traits;

use App\Models\Seo;
use Illuminate\Support\Str;

trait HasSeo
{
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function getSeoContent()
    {
        return $this->content
            ?? $this->body
            ?? $this->description
            ?? '';
    }


    public function resolveSchemaType()
    {
        if (method_exists($this, 'getSeoSchemaType')) {
            return $this->getSeoSchemaType();
        }

        return 'Article';
    }
    public function resolveMetaDescription()
    {
        if (method_exists($this, 'getSeoMetaDescription')) {
            return $this->getSeoMetaDescription();
        }

        return 'Article';
    }
   

   
    protected static function bootHasSeo()
    {
        static::created(function ($model) {
            if (! $model->seo) {
                $model->seo()->create([
                    'meta_title' => $model->title ?? null,
                    'meta_description' => Str::limit(strip_tags($model->resolveMetaDescription()), 150),
                    'robots' => 'index',

                    'schema_type' => $model->resolveSchemaType(),

                    'author' => 'CMS',
                ]);
            }
        });

        static::updating(function ($model) {
            if ($model->seo && empty($model->seo->meta_title)) {
                $model->seo->update([
                    'meta_title' => $model->title,
                ]);
            }
        });
    }

    public function getSchemaTypeAttribute()
    {
        return $this->seo?->schema_type ?? $this->resolveSchemaType();
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->seo?->meta_description ?? $this->getSeoContent();
    }
  
}
