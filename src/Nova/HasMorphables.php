<?php

namespace Authanram\NovaMorphable\Nova;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\MorphMany;

trait HasMorphables
{
    private static function morphables(): Field
    {
        return MorphMany::make(__('Morphables'), 'morphables', Morphable::class);
    }
}
