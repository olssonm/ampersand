<?php

namespace Olssonm\Ampersand\Http\Controllers;

use Illuminate\Http\Response;
use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Repositories\PostRepository;

class PostController
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(): Response
    {
        return response()->view('ampersand::index', [
            'posts' => $this->postRepository->paginate(
                config('ampersand.per_page'),
                config('ampersand.page_indicator'),
            )
        ]);
    }

    public function show(Post $post): Response
    {
        return response()->view('ampersand::show', [
            'post' => $post
        ]);
    }
}
