<?php

namespace App;

use App\Traits\HasEnumHelpers;

enum PostStatus: string
{
    use HasEnumHelpers;
    
    case Draft = "draft";
    case Published = "published";
    case Scheduled = "scheduled";
    case Archived = "archived";

    public function label()
    {
        return match ($this)
        {

            self::Draft => "Draft",
            self::Published => "Published",
            self::Scheduled => "Scheduled",
            self::Archived => "Archived",
        };
    }
}
