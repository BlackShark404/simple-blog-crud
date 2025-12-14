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

        $count = static::where('slug', 'LIKE', "{$original}%")->count();

        return $count? "{$original}-{$count}" : $slug;
    }
}