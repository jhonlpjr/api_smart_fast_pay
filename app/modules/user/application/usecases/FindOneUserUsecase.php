<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\repository\UserRepository;
use DI\ContainerBuilder;

class FindOneUserUsecase
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(require __DIR__ .'\..\..\infraestructure\containers\UserContainer.php');
        $container = $containerBuilder->build();
        $this->userRepository = $container->get(UserRepository::class);
    }

    public function execute(int $userId)
    {
        try {
            $user = $this->userRepository->findById($userId);
            return $user;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}