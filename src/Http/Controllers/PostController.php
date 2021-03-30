<?php

namespace Olssonm\Ampersand\Http\Controllers;

use Olssonm\Ampersand\Models\Post;
use Olssonm\Ampersand\Repositories\PostRepository;

class PostController
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        return view('ampersand::index', [
            'posts' => $this->postRepository->paginate(10)->get()
        ]);
    }

    public function show(Post $post)
    {
        return view('ampersand::show', [
            'post' => $post
        ]);
    }
}
