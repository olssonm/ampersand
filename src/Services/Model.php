<?php

namespace Olssonm\Ampersand\Services;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Sheets\Sheet;

abstract class Model extends Sheet implements UrlRoutable
{
    public function resolveRouteBinding($value, $field = null)
    {
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
    }
}
