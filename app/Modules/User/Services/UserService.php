<?php

namespace App\Modules\User\Services;

use App\Modules\User\Resources\UserCollection;
use App\Modules\User\Repositories\UsersRepository;
use App\Modules\User\Requests\ListAllUsersRequest;

class UserService
{
    public function __construct(private UsersRepository $usersRepository)
    {
    }

    public function createUser($request)
    {
        $user = $this->constructUserModel($request);
        return $this->usersRepository->create($user);
    }

    public function updateUser($id, $request)
    {
        $user = $this->constructUserModel($request);
        return $this->usersRepository->update($id, $user);
    }

    public function deleteUser($id)
    {
        return $this->usersRepository->delete($id);
    }

    public function listAllUsers(array $queryParameters)
    {
        // Construct Query Criteria
        $listAllUsers = (new ListAllUsersRequest)->constructQueryCriteria($queryParameters);

        // Get Countries from Database
        $users = $this->usersRepository->findAllBy($listAllUsers);

        return [
            'data' => new UserCollection($users['data']),
            'count' => $users['count']
        ];
    }

    public function toggleUserStatus($id)
    {
        $user = $this->usersRepository->find($id);
        $user->toggleStatus();
        return $user;
    }

    public function getUserById($id)
    {
        return $this->usersRepository->find($id);
    }

    public function constructUserModel($request)
    {
        $userModel = [
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'role' => $request['role'],
            'image' => $request['image']?? null,
            'is_active' => $request['isActive']?? true,
        ];
        if(isset ($request['password'])){
            $userModel['password'] = $request['password'];
        }

        return $userModel;
    }

    public function getUserByEmail($email){
        return $this->usersRepository->getUserByEmail($email);
    }

    public function changePassword($request){
        $user = $this->usersRepository->find($request['id']);
        $user->password = bcrypt($request['password']);
        return $user->save();
    }
}
