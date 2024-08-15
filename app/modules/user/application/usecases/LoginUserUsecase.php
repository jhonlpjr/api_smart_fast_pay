<?php

namespace app\modules\user\application\usecases;

use app\modules\user\domain\repository\UserRepository;
use app\modules\user\infraestructure\database\models\TokenModel;
use DI\ContainerBuilder;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class LoginUserUsecase
{
    private UserRepository $userRepository;
    private string $jwtSecret;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(require __DIR__ .'\..\..\infraestructure\containers\UserContainer.php');
        $container = $containerBuilder->build();

        $this->userRepository = $container->get(UserRepository::class);
        $this->jwtSecret = 'secret';
    }

    public function execute(string $email, string $password): string
    {
        try {
            $user = $this->userRepository->findByUserName($email);

            if (!$user || !password_verify($password, $user->password)) {
                throw new Exception('Invalid credentials');
            }

            $payload = [
                'iss' => 'your-issuer', // Issuer
                'sub' => $user->id, // Subject
                'iat' => time(), // Issued at
                'exp' => time() + 3600 // Expiration time (1 hour)
            ];
            $token = JWT::encode($payload, $this->jwtSecret, 'HS256');
            TokenModel::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);
            return $token;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}