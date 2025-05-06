<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Repositories\Eloquent\TodoRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Interfaces\StatRepositoryInterface;
use App\Repositories\Eloquent\StatRepository;



class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
        $this->app->bind(StatRepositoryInterface::class, StatRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
