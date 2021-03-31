<?php

namespace Olssonm\Ampersand\Tests;

use Illuminate\Support\Facades\Artisan;
use Olssonm\Ampersand\Tests\TestCase;

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
    }

    /**
     * @test
     */
    public function config_is_correct()
    {
        $this->assertIsArray(config('ampersand'));
        $this->assertEquals(base_path('posts'), config('ampersand.posts_path'));
        $this->assertEquals('page', config('ampersand.page_indicator'));
    }

    /**
     * @test
     */
    public function config_is_editable()
    {
        $this->app['config']->set('ampersand.posts_path', resource_path('posts'));

        $this->assertEquals(resource_path('posts'), config('ampersand.posts_path'));
    }
}
