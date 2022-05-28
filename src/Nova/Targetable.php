<?php

namespace Authanram\NovaMorphable\Nova;

use App\Nova\Resource;
use Authanram\NovaMorphable\Models\Morphable;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\URL;

class Targetable extends Resource
{
    public static string $model = Morphable::class;

    public static $displayInNavigation = false;

    public static function label(): string
    {
        return __('Targetables');
    }

    public static function singularLabel(): string
    {
        return __('Targetable');
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource): URL|string
    {
        return self::redirectUrl($request) ?? parent::redirectAfterCreate($request, $resource);
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource): URL|string
    {
        return self::redirectUrl($request) ?? parent::redirectAfterUpdate($request, $resource);
    }

    public static function redirectAfterDelete(NovaRequest $request): URL|string
    {
        return self::redirectUrl($request) ?? parent::redirectAfterDelete($request);
    }

    public function fields(NovaRequest $request): array
    {
        return [
            self::fieldId(),
            ...self::morphableFields($request),
            ...self::targetableFields($request),
            ...config('nova-morphable.fields', static fn () => [])($request, $this->resource),
        ];
    }

    private static function fieldId(): Field
    {
        return ID::make()->sortable();
    }

    private static function morphableFields(NovaRequest $request): array
    {
        $resources = config('nova-morphable.morphable');

        if (self::isInResources($request, $resources)) {
            return [];
        }

        return [
            MorphTo::make(__('Type'), 'morphable')
                ->types($resources)
                ->withoutTrashed()
                ->showCreateRelationButton(),
        ];
    }

    private static function targetableFields(NovaRequest $request): array
    {
        $resources = config('nova-morphable.targetable');

        if (self::isInResources($request, $resources)) {
            return [];
        }

        return [
            MorphTo::make(__('Type'), 'targetable')
                ->types($resources)
                ->withoutTrashed()
                ->showCreateRelationButton(),
        ];
    }

    private static function isInResources(NovaRequest $request, array $resources): bool
    {
        $key = $request->get('viaResource');

        /** @var Resource|string $resource */
        foreach ($resources as $resource) {
            if ($resource::uriKey() === $key) {
                return true;
            }
        }

        return false;
    }

    private static function redirectUrl(NovaRequest $request): ?string
    {
        if ($request->viaRelationship() === false) {
            return null;
        }

        return 'resources'
            .'/'
            .$request->get('viaResource')
            .'/'
            .$request->get('viaResourceId');
    }
}
