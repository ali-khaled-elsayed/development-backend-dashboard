<?php

namespace App\Modules\Blog\Repositories;

use App\Models\Blog;
use App\Modules\Shared\Repositories\BaseRepository;

class BlogRepository extends BaseRepository
{
    public function __construct(private Blog $model)
    {
        parent::__construct($model);
    }
}
