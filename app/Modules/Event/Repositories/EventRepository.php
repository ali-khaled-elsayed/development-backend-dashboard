<?php

namespace App\Modules\Event\Repositories;

use App\Models\Events;
use App\Modules\Shared\Repositories\BaseRepository;

class EventRepository extends BaseRepository
{
    public function __construct(private Events $model)
    {
        parent::__construct($model);
    }
}
