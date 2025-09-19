<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Contracts\MovieProviderInterface;

use App\Infra\Repositories\UserRepository;
use App\Infra\Services\TMDBService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MovieProviderInterface::class, TMDBService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
