<?php

namespace Olssonm\Ampersand\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Olssonm\Ampersand\Models\Post;

class PostRepository
{
    public function all(): Collection
    {
        return sheets('posts')->all()
            ->sortByDesc('date')
            ->values();
    }

    public function find(string $slug): Post
    {
        $post = $this->all()->where('slug', $slug)->first();

        throw_if(!$post, (new ModelNotFoundException())->setModel(Post::class, $slug));

        return $post;
    }

    public function paginate($perPage = 10, $pageName = 'page'): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage($pageName, 1);

        return new LengthAwarePaginator(
            $this->all()->forPage($page, $perPage),
            $this->all()->count(),
            $perPage,
            null,
            [
                'pageName' => $pageName,
                'path' => request()->getBasePath()
            ]
        );
    }
}
