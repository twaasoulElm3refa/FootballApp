<?php

namespace App\Providers;

use App\Repository\Contracts\fixtures\FixturesRepositoryInterface;
use App\Repository\Contracts\leagues\LeagueRepositoryInterface;
use App\Repository\Contracts\User\UserRepositoryInterface;
use App\Repository\Eloquent\fixtures\FixtureRepository;
use App\Repository\Eloquent\leagues\LeaguesRepository;
use App\Repository\Eloquent\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LeagueRepositoryInterface::class, LeaguesRepository::class);
        $this->app->bind(FixturesRepositoryInterface::class, FixtureRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
