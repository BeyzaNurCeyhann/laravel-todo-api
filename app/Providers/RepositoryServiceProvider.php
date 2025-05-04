<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Repositories\Eloquent\TodoRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
