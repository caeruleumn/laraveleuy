<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\SiswaRepositoryInterface;
use App\Repositories\SiswaRepository;
use App\Contracts\Repositories\KbmRepositoryInterface;
use App\Repositories\KbmRepository;
use App\Contracts\Services\SiswaServiceInterface;
use App\Services\SiswaService;
use App\Contracts\Services\KbmServiceInterface;
use App\Services\KbmService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SiswaRepositoryInterface::class, SiswaRepository::class);
        $this->app->bind(KbmRepositoryInterface::class, KbmRepository::class);
        $this->app->bind(SiswaServiceInterface::class, SiswaService::class);
        $this->app->bind(KbmServiceInterface::class, KbmService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
