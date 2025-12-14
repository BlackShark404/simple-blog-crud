<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug 
{
    protected static function bootHasSlug() 
    {
        static::creating(function ($model) 
        {
            $model->slug = static::generateUniqueSlug($model->title);
        });
    }

    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;

        $count = static::where('slug', 'LIKE', "original%")->count();

        if ($count > 0)
        {
            $slug = "{$original}-{$count}";
        }

        return $slug;
    }
}