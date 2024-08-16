<?php
namespace app\modules\user\application\services;
use app\modules\user\application\usecases\CreateUserUsecase;
use app\modules\user\application\usecases\DeleteUserUsecase;
use app\modules\user\application\usecases\FindOneUserUsecase;
use app\modules\user\application\usecases\GetUserBalanceUsecase;
use app\modules\user\application\usecases\LoginUserUsecase;
use app\modules\user\domain\entities\User;

class UserService
{
    private $createUserUseCase;
    private $deleteUserUseCase;
    private $loginUserUseCase;
    private $getUserBalanceUsecase;
    private $findOneUserUsecase;

    public function __construct(
        CreateUserUsecase $createUserUseCase,
        DeleteUserUsecase $deleteUserUseCase,
        LoginUserUsecase $loginUserUseCase,
        GetUserBalanceUsecase $getUserBalanceUsecase,
        FindOneUserUsecase $findOneUserUsecase
    ) {
        $this->createUserUseCase = $createUserUseCase;
        $this->deleteUserUseCase = $deleteUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
        $this->getUserBalanceUsecase = $getUserBalanceUsecase;
        $this->findOneUserUsecase = $findOneUserUsecase;
    }

    public function createUser(User $data)
    {
        return $this->createUserUseCase->execute($data);
    }

    public function deleteUser($id)
    {
        return $this->deleteUserUseCase->execute($id);
    }

    public function loginUser(string $username, string $password)
    {
        return $this->loginUserUseCase->execute($username, $password);
    }

    public function findUserById($id)
    {
        return $this->findOneUserUsecase->execute($id);
    }

    public function getUserBalance($id)
    {
        return $this->getUserBalanceUsecase->execute($id);
    }
}