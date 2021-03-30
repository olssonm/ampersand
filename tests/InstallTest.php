<?php

namespace Olssonm\Ampersand\Tests;

use Illuminate\Support\Facades\Artisan;
use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Tests\TestCase;
use Spatie\Sheets\Sheets;

class InstallTest extends TestCase
{
    /** @test */
    public function package_config_can_be_installed()
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Olssonm\Ampersand\AmpersandServiceProvider'
        ]);

        $output = Artisan::output();
        $this->assertStringContainsString('Copied File', $output);
        $this->assertStringContainsString('Copied Directory', $output);

        $this->app['config']->set('sheets.collections', [
            'posts' => [
                'disk' => 'ampersand::posts',
                'sheet_class' => Post::class,
                'path_parser' => SlugWithDateParser::class,
                'content_parser' => MarkdownWithFrontMatterParser::class,
                'extension' => 'md',
            ]
        ]);
    }

    /**
     * @test
     * @depends package_config_can_be_installed
     */
    public function config_is_correct()
    {
        $this->assertIsArray(config('ampersand'));
        $this->assertEquals(base_path('posts'), config('ampersand.posts_path'));
    }
}
