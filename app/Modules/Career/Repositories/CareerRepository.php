<?php

namespace App\Modules\Career\Repositories;

use App\Models\Careers;
use App\Modules\Shared\Repositories\BaseRepository;

class CareerRepository extends BaseRepository
{
    public function __construct(private Careers $model)
    {
        parent::__construct($model);
    }
}
