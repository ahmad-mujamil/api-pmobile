<?php

namespace App\Providers;

use App\Http\Resources\UserRegistrasiResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        UserResource::withoutWrapping();
        UserRegistrasiResource::withoutWrapping();
        Gate::define('viewApiDocs', fn () => true);
//        Gate::allows('viewApiDocs');
    }
}
