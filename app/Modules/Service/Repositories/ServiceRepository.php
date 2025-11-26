<?php

namespace App\Modules\Service\Repositories;

use App\Models\Service;
use App\Modules\Shared\Repositories\BaseRepository;

class ServiceRepository extends BaseRepository
{
    public function __construct(private Service $model)
    {
        parent::__construct($model);
    }
}
