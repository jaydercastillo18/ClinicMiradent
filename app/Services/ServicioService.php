<?php

namespace App\Services;

use App\Repositories\ServicioRepository;
use App\Support\CacheKeys;
use App\ViewModels\DoctoraViewModel;
use App\ViewModels\ServicioViewModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ServicioService
{
    public function __construct(
        private ServicioRepository $servicioRepository
    ) {}

    /**
     * Get active services for the home page (cached).
     */
    public function getForHome(DoctoraViewModel $doctora): Collection
    {
        // Aumentado a 6 para el nuevo diseño del homepage (tratamientos más buscados)
        $models = Cache::remember(CacheKeys::SERVICIOS_HOME, 3600, function () {
            return $this->servicioRepository->getActiveLimit(6);
        });

        return ServicioViewModel::collection($models, $doctora);
    }

    /**
     * Get filtered active services for the public listing page.
     */
    public function getFiltered(string $search, ?string $category, DoctoraViewModel $doctora): Collection
    {
        $models = $this->servicioRepository->getFiltered($search, $category, false);

        return ServicioViewModel::collection($models, $doctora);
    }

    /**
     * Get paginated filtered services for JSON API responses.
     */
    public function getPaginated(string $search, ?string $category, int $perPage = 12): LengthAwarePaginator
    {
        return $this->servicioRepository->getFiltered($search, $category, true, $perPage);
    }

    /**
     * Get unique active categories for filter pills.
     */
    public function getCategorias(): array
    {
        return Cache::remember(CacheKeys::SERVICIOS_CATEGORIAS, 3600, function () {
            return $this->servicioRepository->getCategorias();
        });
    }

    /**
     * Find service by ID
     */
    public function findById(int $id)
    {
        return $this->servicioRepository->findById($id);
    }

    /**
     * Build category filter objects for the UI pills.
     */
    public function buildCategoryFilters(array $categorias, string $search, ?string $selectedCategory): Collection
    {
        return collect(['Todas', ...$categorias])->map(function (string $category) use ($search, $selectedCategory) {
            $query = array_filter([
                'search' => $search,
                'category' => $category === 'Todas' ? null : $category,
            ], fn ($value) => $value !== null && $value !== '');

            $activeCategory = $selectedCategory ?: 'Todas';

            return (object) [
                'label' => $category,
                'url' => route('public.servicios', $query),
                'class' => $activeCategory === $category ? 'active' : '',
            ];
        });
    }
}
