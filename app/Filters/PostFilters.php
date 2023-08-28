<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class PostFilters extends QueryFilters
{
    protected array $allowedFilters = ['category_id', 'status'];

    protected array $columnSearch = ['title', 'content'];
}
