<?php

use Illuminate\Support\Facades\Artisan;
use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Tests\TestCase;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;
use Spatie\Sheets\Sheets;

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
    public function correct_number_of_posts()
    {
        $this->assertEquals(2, Post::all()->count());
    }

    /** @test */
    public function post_has_all_attributes()
    {
        $post = Post::find('post-2');
        $this->assertEquals('2020-02-01 20:00:01', $post->date);
        $this->assertEquals('post-2', $post->slug);
        $this->assertEquals('My blogpost', $post->title);
        $this->assertEquals('https://amazingimages/my-cover.jpg', $post->cover);
        $this->assertStringContainsString('<p>This is just some random content.</p', (string) $post->contents);
    }

    /** @test */
    public function post_can_paginate()
    {
        $posts = Post::paginate();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.ampersand::posts', [
            'driver' => 'local',
            'root' => __DIR__ . '/fixtures'
        ]);
        $app['config']->set('sheets', [
            'collections' => [
                'posts' => [
                    'disk' => 'ampersand::posts',
                    'sheet_class' => Post::class,
                    'path_parser' => SlugWithDateParser::class,
                    'content_parser' => MarkdownWithFrontMatterParser::class,
                    'extension' => 'md',
                ]
            ]
        ]);
    }
}
