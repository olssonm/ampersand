<?php

namespace Olssonm\Ampersand\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Repositories\PostRepository;
use Spatie\Sheets\Sheets;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::bind('post', function ($slug, $route) {
            return $this->app->make(PostRepository::class)->find($slug);
        });

        parent::boot();
    }

    public function map(): void
    {
        if (config('ampersand.register_routes')) {
            Route::middleware('web')
                ->group(__DIR__ . '/../Http/routes.php');
        }
    }
}
