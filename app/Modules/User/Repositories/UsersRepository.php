<?php

namespace App\Modules\User\Repositories;

use App\Models\User;
use App\Modules\Shared\Repositories\BaseRepository;

class UsersRepository extends BaseRepository
{
    public function __construct(private User $model)
    {
        parent::__construct($model);
    }

    public function getUserByEmail($email){
        $user = $this->model::where('email',$email)->first();
        return $user;
    }
}
