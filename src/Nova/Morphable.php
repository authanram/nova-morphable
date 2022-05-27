<?php

namespace Authanram\NovaMorphable\Nova;

use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Morphable extends Targetable
{
    use HasSortableRows;

    public static function label(): string
    {
        return __('Morphables');
    }

    public static function singularLabel(): string
    {
        return __('Morphable');
    }
}
