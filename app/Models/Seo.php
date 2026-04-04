<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seos';
    protected $guarded = [];

    public function seoable()
    {
        return $this->morphTo();
    }
}
