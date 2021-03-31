<?php

namespace Olssonm\Ampersand\Tests;

use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Tests\TestCase;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;

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
        $this->assertEquals('My second blogpost', $post->title);
        $this->assertEquals('https://amazingimages/my-cover.jpg', $post->cover);
        $this->assertEquals('http://localhost/blog/post-2', $post->url);
        $this->assertStringContainsString('<p>This is just some random content.</p', (string) $post->contents);
    }

    /** @test */
    public function posts_can_paginate()
    {
        $posts = Post::paginate(1);
        $this->assertEquals(2, $posts->total());
        $this->assertEquals(1, $posts->currentPage());
        $this->assertEquals('?page=2', $posts->nextPageUrl());
        $this->assertEquals('?page=2', $posts->url(2));
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
