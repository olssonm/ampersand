<?php

namespace Olssonm\Ampersand\Tests;

use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Tests\TestCase;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;
use Illuminate\Support\Str;

class CommandTest extends TestCase
{
    /** @test */
    public function it_can_create_new_post()
    {
        $title = 'Yet another test post';
        $date = now();

        $this->artisan('ampersand:new')
            ->expectsQuestion('Title of your new post', $title)
            ->expectsOutput('Created post "Yet another test post"', sprintf('Created post "%s"', $title))
            ->assertExitCode(0);

        $this->assertFileExists(base_path('posts') . '/' . sprintf('%s.%s.md',
            $date->format('Y-m-d'),
            Str::slug($title)
        ));

        // Check the newly created post
        $post = Post::find(Str::slug($title));
        $this->assertInstanceOf(Post::class, $post);
        $this->assertStringContainsString($date->format('Y-m-d'), $post->date->format('Y-m-d'));
        $this->assertEquals(Str::slug($title), $post->slug);
        $this->assertEquals($title, $post->title);
    }

    protected function getEnvironmentSetUp($app)
    {
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
