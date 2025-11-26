<?php

namespace App\Modules\Client\Repositories;

use App\Models\Client;
use App\Modules\Shared\Repositories\BaseRepository;

class ClientRepository extends BaseRepository
{
    public function __construct(private Client $model)
    {
        parent::__construct($model);
    }
}
