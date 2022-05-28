<?php

namespace Authanram\NovaMorphable\Nova;

use Laravel\Nova\Fields\MorphMany as BaseMorphMany;

class MorphMany
{
    public static function make(mixed $name, string $resourceClass): BaseMorphMany
    {
        return in_array($resourceClass, config('nova-morphable.morphable', []), true)
            ? BaseMorphMany::make($name, 'targetables', Targetable::class)
            : BaseMorphMany::make($name, 'morphables', Morphable::class);
    }
}
