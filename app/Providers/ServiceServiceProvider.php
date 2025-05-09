<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Todo\Interfaces\TodoServiceInterface;
use App\Services\Todo\TodoService;
use App\Services\Category\Interfaces\CategoryServiceInterface;
use App\Services\Category\CategoryService;
use App\Services\Stat\Interfaces\StatServiceInterface;
use App\Services\Stat\StatService;
use App\Services\Auth\Interfaces\AuthServiceInterface;
use App\Services\Auth\AuthService;


class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TodoServiceInterface::class, TodoService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(StatServiceInterface::class, StatService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
