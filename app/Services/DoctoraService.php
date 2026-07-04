<?php

namespace App\Services;

use App\Repositories\DoctoraRepository;
use App\Support\CacheKeys;
use App\ViewModels\DoctoraViewModel;
use Illuminate\Support\Facades\Cache;

class DoctoraService
{
    public function __construct(
        private DoctoraRepository $doctoraRepository
    ) {}

    /**
     * Get the public-facing profile of the primary doctor.
     *
     * Centralizes the Doctora query + cache that was previously duplicated
     * across PublicController (4 methods) and AppServiceProvider.
     */
    public function getPublicProfile(): DoctoraViewModel
    {
        $model = Cache::remember(CacheKeys::DOCTORA_HOME, 3600, function () {
            return $this->doctoraRepository->getFirstWithUser();
        });

        return DoctoraViewModel::make($model);
    }
}
