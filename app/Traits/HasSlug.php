<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->title)) {
                $model->slug = static::generateUniqueSlug($model->title);
            }
        });
    }

    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 0;

        // Loop until a unique slug is found
        while (static::where('slug', $slug)->exists()) {
            $count++;
            $slug = "{$original}-{$count}";
        }

        return $slug;
    }
}