<?php

namespace App\Providers;

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
        //
        $this->app->bind(
            \App\Domain\Repositories\ICardRepository::class,
            \App\Infrastructure\Repositories\CardRepository::class,

        );
        $this->app->bind(
            \App\Domain\Repositories\IProductRepository::class,
            \App\Infrastructure\Repositories\ProductRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
