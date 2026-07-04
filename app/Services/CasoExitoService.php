<?php

namespace App\Services;

use App\Repositories\CasoExitoRepository;
use App\Support\CacheKeys;
use App\ViewModels\CasoExitoViewModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CasoExitoService
{
    public function __construct(
        private CasoExitoRepository $casoExitoRepository
    ) {}

    /**
     * Get active success cases for the home page (cached, with images only).
     */
    public function getForHome(): Collection
    {
        $models = Cache::remember(CacheKeys::CASOS_HOME, 3600, function () {
            return $this->casoExitoRepository->getActive();
        });

        return CasoExitoViewModel::collection($models, true);
    }
}
