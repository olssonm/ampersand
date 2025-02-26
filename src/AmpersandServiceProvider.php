<?php

namespace Olssonm\Ampersand;

use Illuminate\Support\ServiceProvider;
use Olssonm\Ampersand\Commands\NewPost;
use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Providers\RouteServiceProvider;
use Olssonm\Ampersand\Repositories\PostRepository;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;

class AmpersandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/ampersand.php' => config_path('ampersand.php')
            ], 'config');
            $this->publishes([
                __DIR__ . '/resources/views' => resource_path('views/vendor/ampersand'),
            ], 'views');
        }
    }

    public function register(): void
    {
        $this->setup();
        $this->registerRepositories();
        $this->registerCommands();

        $this->app->register(RouteServiceProvider::class);
    }

    private function setup(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'ampersand');

        $this->mergeConfigFrom(__DIR__ . '/config/ampersand.php', 'ampersand');

        // Add a disk to the filesystem
        config()->set('filesystems.disks.ampersand::posts', [
            'driver' => 'local',
            'root' => config('ampersand.posts_path')
        ]);

        // Overload sheets config to avoid local conflicts
        config()->set('sheets.collections', [
            'posts' => [
                'disk' => 'ampersand::posts',
                'sheet_class' => Post::class,
                'path_parser' => SlugWithDateParser::class,
                'content_parser' => MarkdownWithFrontMatterParser::class,
                'extension' => 'md',
            ]
        ]);
    }

    private function registerRepositories(): void
    {
        $this->app->singleton(PostRepository::class);
    }

    private function registerCommands(): void
    {
        $this->commands([
            NewPost::class
        ]);
    }
}
