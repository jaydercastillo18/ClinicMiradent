<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @method static void saved(\Closure|string|array $callback)
 * @method static void deleted(\Closure|string|array $callback)
 */
trait ClearsPublicCache
{
    /**
     * Boot the trait to automatically clear public caches when a model is saved or deleted.
     */
    protected static function bootClearsPublicCache(): void
    {
        static::saved(function () {
            static::clearAssociatedCache();
        });

        static::deleted(function () {
            static::clearAssociatedCache();
        });
    }

    /**
     * Clear all associated public caches.
     */
    protected static function clearAssociatedCache(): void
    {
        Cache::forget('home_servicios');
        Cache::forget('home_promociones');
        Cache::forget('home_doctora');
        Cache::forget('home_casos_exito');
        Cache::forget('home_testimonios');
        Cache::forget('servicios_categorias');
    }
}
