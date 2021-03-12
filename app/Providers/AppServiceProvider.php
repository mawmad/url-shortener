<?php

namespace App\Providers;

use App\Repositories\EloquentUrlRepository;
use App\Repositories\UrlRepositoryInterface;
use App\Services\ShortenerService;
use App\Services\ShortenerServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UrlRepositoryInterface::class, EloquentUrlRepository::class);
        $this->app->bind(ShortenerServiceInterface::class, ShortenerService::class);
    }
}
