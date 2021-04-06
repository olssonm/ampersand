<?php

namespace Olssonm\Ampersand\Tests;

use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Tests\TestCase;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;

class WebTest extends TestCase
{
    /** @test */
    public function it_can_show_index()
    {
        $response = $this->get(route('ampersand.index'));
        $response->assertStatus(200)
            ->assertSeeText(Post::all()->first()->title)
            ->assertViewHas('posts', Post::paginate(
                config('ampersand.per_page'),
                config('ampersand.page_indicator'),
            ));
    }

    /** @test */
    public function it_can_show_single_post()
    {
        $response = $this->get(route('ampersand.show', Post::all()->first()));
        $response->assertStatus(200)
            ->assertSeeText(Post::all()->first()->title)
            ->assertViewHas('post', Post::all()->first());
    }

    /** @test */
    public function it_has_pagination_links()
    {
        $this->app['config']->set('ampersand.per_page', 1);
        $response = $this->get(route('ampersand.index'));
        $response->assertStatus(200)
            ->assertSeeText(Post::all()->first()->title)
            ->assertSee('?page=2');

        $response = $this->get(route('ampersand.index', ['page' => 2]));
        $response->assertStatus(200)
            ->assertSeeText(Post::all()->skip(1)->first()->title)
            ->assertSee('?page=1');
    }

    /** @test */
    public function it_shows_404()
    {
        $response = $this->get(route('ampersand.show', 'no-post'));
        $response->assertStatus(404)
            ->assertSeeText('Not Found');
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
