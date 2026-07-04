<?php

namespace App\Services;

use App\Repositories\PromocionRepository;
use App\Support\CacheKeys;
use App\ViewModels\DoctoraViewModel;
use App\ViewModels\PromocionViewModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PromocionService
{
    public function __construct(
        private PromocionRepository $promocionRepository
    ) {}

    /**
     * Get active promotions for the home page (cached).
     */
    public function getForHome(DoctoraViewModel $doctora): Collection
    {
        $models = Cache::remember(CacheKeys::PROMOS_HOME, 3600, function () {
            return $this->promocionRepository->getActive(false);
        });

        return PromocionViewModel::collection($models, $doctora);
    }

    /**
     * Get all active promotions for the public listing page.
     */
    public function getActive(DoctoraViewModel $doctora): Collection
    {
        $models = $this->promocionRepository->getActive(false);

        return PromocionViewModel::collection($models, $doctora);
    }

    /**
     * Get paginated active promotions for JSON API responses.
     */
    public function getActivePaginated(int $perPage = 12): LengthAwarePaginator
    {
        return $this->promocionRepository->getActive(true, $perPage);
    }
}
