<?php

namespace Authanram\NovaMorphable\Nova;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\MorphMany;

trait HasTargetables
{
    private static function targetables(): Field
    {
        return MorphMany::make(__('Targetables'), 'targetables', Targetable::class);
    }
}
