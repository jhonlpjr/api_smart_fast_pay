<?php

namespace app\modules\user\application\usecases;
use app\modules\user\domain\repository\UserRepository;
use DI\ContainerBuilder;

class DeleteUserUsecase
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(require __DIR__ .'\..\..\infraestructure\containers\UserContainer.php');
        $container = $containerBuilder->build();
        $this->userRepository = $container->get(UserRepository::class);
    }

    public function execute(int $userId): void
    {
        try {
            $this->userRepository->delete($userId);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}