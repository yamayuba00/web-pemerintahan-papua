<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $guarded = [];

    public $timestamps = true;

    public static function get($key, $default = null)
    {
        $setting = static::first();

        return $setting?->$key ?? $default;
    }

    public static function set($key, $value)
    {
        $setting = static::first();

        if (!$setting) {
            $setting = static::create([]);
        }

        $setting->$key = $value;
        $setting->save();
    }
}
