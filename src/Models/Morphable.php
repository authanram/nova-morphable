<?php

namespace Authanram\NovaMorphable\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Morphable extends Eloquent implements Sortable
{
    use SortableTrait;

    protected $fillable = [
        'order_column',
    ];

    public array $sortable = [
        'ignore_policies' => true,
        'order_column_name' => 'order_column',
        'sort_on_has_many' => true,
    ];

    public function morphable(): MorphTo
    {
        return $this->morphTo('morphable');
    }

    public function targetable(): MorphTo
    {
        return $this->morphTo('targetable');
    }
}
