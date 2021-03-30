<?php

use Illuminate\Support\Facades\Artisan;
use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Tests\TestCase;

class PostsTest extends TestCase
{
    /** @test */
    public function routes_exists()
    {
        $this->assertEquals('http://localhost/blog', route('ampersand.index'));
        $this->assertEquals('http://localhost/blog/post-1', route('ampersand.show', ['post' => 'post-1']));
        $this->assertEquals('http://localhost/blog/post-2', route('ampersand.show', ['post' => 'post-2']));
    }

    /** @test */
    public function post_has_all_attributes()
    {
        $post = Post::find('post-1');
    }

    protected function getEnvironmentSetUp($app)
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Olssonm\Ampersand\AmpersandServiceProvider'
        ]);

        config()->set('ampersand.posts_path', __DIR__ . '/fixtures');
    }
}
