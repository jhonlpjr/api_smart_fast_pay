<?php

namespace app\modules\user\infraestructure\database\repositories;

use app\modules\user\domain\entities\User;
use app\modules\user\domain\repository\UserRepository;
use app\modules\user\infraestructure\database\models\UserModel;

class UserMysqlRepository implements UserRepository {
    public function findById(int $id): ?UserModel {
        return UserModel::find($id);
    }

    public function findByUserName(string $username)
    {
        return UserModel::where('username', $username)->first();
    }

    public function save(User $user) {
        $userModel = new UserModel($user->toArray());
        $userModel->save();
        return $userModel;
    }

    public function update(int $id, User $user) {
        $userModel = UserModel::find($id);
        $userModel->fill($user->toArray());
        $userModel->save();
        return $userModel;
    }

    public function delete(int $id) {
        return UserModel::destroy([$id]);
    }

}