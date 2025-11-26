<?php

namespace App\Modules\PropertyTypes\Repositories;

use App\Models\PropertyType;
use App\Modules\Shared\Repositories\BaseRepository;

class PropertyRepository extends BaseRepository
{
    public function __construct(private PropertyType $model)
    {
        parent::__construct($model);
    }
}
