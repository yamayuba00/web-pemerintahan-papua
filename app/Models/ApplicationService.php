<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationService extends Model
{
    protected $table = 'application_services';

    protected $fillable = [
        'title',
        'description',
        'url',
    ];
}
