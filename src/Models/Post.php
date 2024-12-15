<?php

namespace Olssonm\Ampersand\Models;

use AllowDynamicProperties;
use Carbon\Carbon;
use Olssonm\Ampersand\Repositories\PostRepository;
use Olssonm\Ampersand\Services\Model;

/**
 * @property string $slug
 */
#[AllowDynamicProperties]
class Post extends Model
{
    public function getRouteKey(): string
    {
        return $this->slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getUrlAttribute(): string
    {
        return route('ampersand.show', $this->slug);
    }

    public function getDateAttribute(): Carbon
    {
        return Carbon::parse($this->attributes['date']);
    }

    /** @phpstan-ignore-next-line */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        /** @phpstan-ignore-next-line */
        return call_user_func_array([app(PostRepository::class), $name], $arguments);
    }
}
