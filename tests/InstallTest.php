<?php

namespace Olssonm\Ampersand\Tests;

use Illuminate\Support\Facades\Artisan;
use Olssonm\Ampersand\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class InstallTest extends TestCase
{
    #[Test]
    public function it_can_be_installed()
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Olssonm\Ampersand\AmpersandServiceProvider'
        ]);

        $output = Artisan::output();

        $this->assertStringContainsString('DONE', $output);

        $this->assertFileExists(config_path('ampersand.php'));
        $this->assertDirectoryExists(resource_path('views/vendor/ampersand'));
    }

    #[Test]
    public function it_has_correct_config()
    {
        $this->assertIsArray(config('ampersand'));
        $this->assertEquals(base_path('posts'), config('ampersand.posts_path'));
        $this->assertEquals('page', config('ampersand.page_indicator'));
    }

    #[Test]
    public function it_has_editable_config()
    {
        $this->app['config']->set('ampersand.posts_path', resource_path('posts'));

        $this->assertEquals(resource_path('posts'), config('ampersand.posts_path'));
    }
}
