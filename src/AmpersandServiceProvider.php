<?php

namespace Olssonm\Ampersand;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Olssonm\Ampersand\Macros\CollectionMixin;
use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Providers\RouteServiceProvider;
use Olssonm\Ampersand\Repositories\PostRepository;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;

class AmpersandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setup();
        $this->registerRepositories();

        $this->app->register(RouteServiceProvider::class);
    }

    private function setup()
    {
        $this->publishes([
            __DIR__ . '/config/ampersand.php' => config_path('ampersand.php'),
            __DIR__ . '/resources/views' => resource_path('views/vendor/ampersand'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'ampersand');

        $this->mergeConfigFrom(
            __DIR__ . '/config/ampersand.php',
            'ampersand'
        );

        // Add a disk to the filesystem
        config()->set('filesystems.disks.ampersand::posts', [
            'driver' => 'local',
            'root' => config('ampersand.posts_path')
        ]);

        // Overload sheets config to avoid local conflicts
        config(['sheets.collections' => [
            'posts' => [
                'disk' => 'ampersand::posts',
                'sheet_class' => Post::class,
                'path_parser' => SlugWithDateParser::class,
                'content_parser' => MarkdownWithFrontMatterParser::class,
                'extension' => 'md',
            ]
        ]]);
    }

    private function registerRepositories()
    {
        $this->app->singleton(PostRepository::class);
    }
}
