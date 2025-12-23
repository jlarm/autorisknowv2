<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\FathomService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FathomService::class, function () {
            return new FathomService(
                apiToken: config('services.fathom.api_token'),
                siteId: config('services.fathom.site_id'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootModelsDefaults();
    }

    private function bootModelsDefaults(): void
    {
        Model::unguard();
    }
}
