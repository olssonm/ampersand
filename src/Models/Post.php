<?php

namespace Olssonm\Ampersand\Models;

use Olssonm\Ampersand\Repositories\PostRepository;
use Olssonm\Ampersand\Services\Model;

class Post extends Model
{
    public function getRouteKey()
    {
        return $this->slug;
    }

    public function getUrlAttribute()
    {
        return route('ampersand.show', $this->slug);
    }

    public function getAuthorAttribute()
    {
        if (isset($this->attributes['author'])) {
            return $this->attributes['author'];
        }
        return config('ampersand.author');
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([app(PostRepository::class), $name], $arguments);
    }
}
