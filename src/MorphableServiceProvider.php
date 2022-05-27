<?php

namespace Authanram\NovaMorphable;

use Authanram\NovaMorphable\Models\Morphable as Model;
use Authanram\NovaMorphable\Nova\Morphable;
use Authanram\NovaMorphable\Nova\Targetable;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class MorphableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'nova-morphable');

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('nova-morphable.php'),
        ]);

        Nova::resources([
            Morphable::class,
            Targetable::class,
        ]);

        /** @var Resource|string $resource */
        foreach (config('nova-morphable.targetable') as $resource) {
            $resource::newModel()::class::resolveRelationUsing('morphables', static function ($model) {
                return $model->morphMany(Model::class, 'targetable');
            });
        }

        /** @var Resource|string $resource */
        foreach (config('nova-morphable.morphable') as $resource) {
            $resource::newModel()::class::resolveRelationUsing('targetables', static function ($model) {
                return $model->morphMany(Model::class, 'morphable');
            });
        }
    }
}
