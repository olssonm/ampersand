<?php

namespace Olssonm\Ampersand\Models;

use Carbon\Carbon;
use Olssonm\Ampersand\Repositories\PostRepository;
use Olssonm\Ampersand\Services\Model;

class Post extends Model
{
    public function getRouteKey(): string
    {
        return $this->slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlAttribute(): string
    {
        return route('ampersand.show', $this->slug);
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['date']);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([app(PostRepository::class), $name], $arguments);
    }
}
