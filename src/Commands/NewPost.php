<?php

namespace Olssonm\Ampersand\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class NewPost extends Command
{
    protected $signature = 'ampersand:new';

    protected $description = 'Create a new post';

    public function handle()
    {
        $title = $this->ask('Title of your new post');
        $date = now();

        $file = sprintf('%s.%s.md', $date->format('Y-m-d'), Str::slug($title));

        $content = file_get_contents(__DIR__ . '/../resources/stubs/post.md');
        $content = Str::of($content)->replace('%title%', $title)
            ->replace('%date%', $date);

        $directory = config('ampersand.posts_path');
        File::ensureDirectoryExists($directory);

        file_put_contents($directory . '/' . $file, $content);

        $this->info(sprintf('Created post "%s"', $title));
    }
}
