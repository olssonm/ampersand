<?php

namespace Olssonm\Ampersand\Services;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Sheets\Sheet;

abstract class Model extends Sheet implements UrlRoutable
{
    /** @phpstan-ignore return.missing */
    public function resolveRouteBinding($value, $field = null)
    {
    }

    /** @phpstan-ignore return.missing */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
    }
}
