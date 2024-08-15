<?php

namespace app\modules\user\domain\repository;

use app\modules\user\domain\entities\User;

interface UserRepository
{
    public function findById(int $id);

    public function findByUserName(string $username);

    public function save(User $user);

    public function update(int $id, User $user);

    public function delete(int $id);
}