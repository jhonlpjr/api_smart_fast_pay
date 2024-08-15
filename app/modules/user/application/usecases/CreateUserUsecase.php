<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\entities\User;
use app\modules\user\domain\repository\UserRepository;
use DI\ContainerBuilder;

class CreateUserUsecase
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(require __DIR__ . '\..\..\infraestructure\containers\UserContainer.php');
        $container = $containerBuilder->build();

        $this->userRepository = $container->get(UserRepository::class);
    }

    public function execute(User $userData)
    {
        try {
            $userData->password = password_hash($userData->password, PASSWORD_BCRYPT);
            return  $this->userRepository->save($userData);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
