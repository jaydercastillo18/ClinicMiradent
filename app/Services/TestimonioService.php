<?php

namespace App\Services;

use App\Repositories\TestimonioRepository;
use App\Support\CacheKeys;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TestimonioService
{
    public function __construct(
        private TestimonioRepository $testimonioRepository
    ) {}

    /**
     * Get active testimonials for the home page (cached).
     */
    public function getForHome(): Collection
    {
        return Cache::remember(CacheKeys::TESTIMONIOS_HOME, 3600, function () {
            return $this->testimonioRepository->getActive();
        });
    }
}
