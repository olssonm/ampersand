<?php

namespace Olssonm\Ampersand\Tests;

use Illuminate\Support\Facades\Artisan;
use Olssonm\Ampersand\Tests\TestCase;

class InstallTest extends TestCase
{
    /** @test */
    public function it_can_be_installed()
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Olssonm\Ampersand\AmpersandServiceProvider'
        ]);

        $output = Artisan::output();

        $version = explode('.', app()->version())[0];

        if ((int) $version >= 9) {
            $this->assertStringContainsString('DONE', $output);
        } else {
            $this->assertStringContainsString('Copied File', $output);
            $this->assertStringContainsString('Copied Directory', $output);
        }

        $this->assertFileExists(config_path('ampersand.php'));
        $this->assertDirectoryExists(resource_path('views/vendor/ampersand'));
    }

    /**
     * @test
     */
    public function it_has_correct_config()
    {
        $this->assertIsArray(config('ampersand'));
        $this->assertEquals(base_path('posts'), config('ampersand.posts_path'));
        $this->assertEquals('page', config('ampersand.page_indicator'));
    }

    /**
     * @test
     */
    public function it_has_editable_config()
    {
        $this->app['config']->set('ampersand.posts_path', resource_path('posts'));

        $this->assertEquals(resource_path('posts'), config('ampersand.posts_path'));
    }
}
